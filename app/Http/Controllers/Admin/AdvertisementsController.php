<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Setting;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AdvertisementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ImageTrait;

    public function index()
    {
        $ads = Ad::query()->paginate(8);
        foreach ($ads as $ad) {
            $ad->image = $this->getLogo($ad->image);
        }

        $settings = Setting::first();
        $settings->logo = $this->getLogo($settings->logo);
        return Inertia::render('Advertisements/Index', [
            'settings' => $settings,
            'advertisements' => $ads,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = Setting::first();
        $settings->logo = $this->getLogo(image: $settings->logo);
        return Inertia::render('Advertisements/Create', [
            'settings' => $settings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $request->validate([
            'full_name' => ['required', 'min:2'],
            'ad_url' => ['required', 'min:2'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'location' => ['required', 'string'],
            'image' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);


        $image = $this->setLogo($request, 'advertisement');


        Ad::create([
            'full_name' => $request->full_name,
            'ad_url' => $request->ad_url,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'image' => $image,
            'hit' => 0,
        ]);

        return Redirect::route('advertisements.index')->with('message', 'Advertisement created successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */

    public function show(Ad $advertisement)
    {
        $settings = Setting::first();
        $settings->logo = $this->getLogo(image: $settings->logo);
        $advertisement->image = $this->getLogo(image: $advertisement->image);

        

        return Inertia::render('Advertisements/Show', [
            'advertisement' => $advertisement,
            'settings' => $settings,
        ]);
    }
    public function edit(Ad $advertisement)
    {
        $settings = Setting::first();
        $settings->logo = $this->getLogo(image: $settings->logo);
        return Inertia::render('Advertisements/Edit', [
            'advertisement' => $advertisement,
            'settings' => $settings,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $advertisement)
    {

        $request->validate([
            'full_name' => ['required', 'min:2'],
            'ad_url' => ['required', 'min:2'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'location' => ['required', 'string'],
            'image' => ['nullable','image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $image = $advertisement->image;

        if ($request->hasFile('image')) {
            if (file_exists(public_path($image))) {
                File::delete(public_path($image));
            }
            $image = $this->setLogo($request, 'advertisement');
        }

        $advertisement->update([
            'full_name'       => $request->full_name,
            'ad_url'       => $request->ad_url,
            'start_date'        => $request->start_date,
            'end_date'       => $request->end_date,
            'location'       => $request->location,
            'image'        => $image,

        ]);

        return Redirect::route('advertisements.index')->with('message', 'Advertisement updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $advertisement)
    {
        if (file_exists(public_path($advertisement->image))) {
            File::delete(public_path($advertisement->image));
        }
        $advertisement->delete();
        return Redirect::back()->with('message', 'Car deleted successfully');
    }
}
