<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ImageTrait;

    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = Review::query();

        if ($status === 'approved') {
            $query->where('status', 1);
        } elseif ($status === 'rejected') {
            $query->where('status', 0);
        }

        $reviews = $query->latest()->paginate(8);

        $settings = Setting::first();
        if ($settings) {
            $settings->logo = $this->getLogo($settings->logo);
        }
        return Inertia::render('Reviews/Index', [
            'reviews' => $reviews,
            'settings' => $settings,
            'filterStatus' => $status ?? 'all',
            'translations' => trans('messages'),
            'locale' => App::getLocale(),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $review = Review::findOrFail($id);
        $review->status = $request->status;

        $review->save();

        return Redirect::back()->with('message', 'Review status updated successfully.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:2'],
            'phone' => ['required', 'min:2'],
            'is_public' => ['required'],
            'content' => ['required', 'string'],
        ]);


        Review::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'is_public' => $request->is_public,
            'content' => $request->content,
            'status' => 2,
        ]);

        return Redirect::back()->with('message', 'Review  added successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */

    public function show(Ad $advertisement)
    {
        $settings = Setting::first();
        if ($settings) {
            $settings->logo = $this->getLogo($settings->logo);
        }
        $advertisement->image = $this->getLogo(image: $advertisement->image);



        return Inertia::render('Advertisements/Show', [
            'advertisement' => $advertisement,
            'settings' => $settings,
        ]);
    }
    public function edit(Ad $advertisement)
    {
        $settings = Setting::first();
        if ($settings) {
            $settings->logo = $this->getLogo($settings->logo);
        }
        return Inertia::render('Advertisements/Edit', [
            'advertisement' => $advertisement,
            'settings' => $settings,
            'translations' => trans('messages'),
            'locale' => App::getLocale(),
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
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
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
