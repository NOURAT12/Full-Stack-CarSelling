<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;



class SellerController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $user = auth()->user()->id;
        $cars = Car::where('user_id', $user)->paginate(8);
        foreach ($cars as $car) {
            $images = json_decode($car->carimages, true);
            $car->image = $this->getLogo($images[0]);
        }

        $settings = Setting::first();
        $settings->logo = $this->getLogo(image: $settings->logo);
        return Inertia::render('Cars/Index', [
            'settings' => $settings,
            'cars' => $cars,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = Setting::first();
        $settings->logo = $this->getLogo(image: $settings->logo);
        return Inertia::render('Cars/Create', [
            'settings' => $settings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $request->validate([
            'brand' => ['required', 'min:2'],
            'model' => ['required', 'min:2'],
            'year' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'color' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
            'sold' => ['required', 'boolean'],
            'description' => ['nullable', 'string'],
            'carimages' => ['required', 'array'],
            'carimages.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'], // صور متعددة
        ]);



        $imagePaths = [];
        if ($request->hasFile('carimages')) {
            foreach ($request->file('carimages') as $image) {
                $imagePaths[] = $this->setImages($image, 'car');
            }
        }

        Car::create([
            'user_id' => Auth::id(),
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'price' => $request->price,
            'color' => $request->color,
            'city' => $request->city,
            'country' => $request->country,
            'sold' => $request->sold,
            'description' => $request->description,
            'carimages' => json_encode($imagePaths)
        ]);

        return Redirect::route('cars.index')->with('message', 'Car created successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */

    public function show(Car $car)
    {
        $settings = Setting::first();
        $settings->logo = $this->getLogo(image: $settings->logo);

        $imagePaths = json_decode($car->carimages, true); // نحول النص إلى مصفوفة

        $carImages = [];

        if (is_array($imagePaths)) {
            foreach ($imagePaths as $path) {
                $carImages[] = $this->getImage($path);
            }
        }

        $car->images = $carImages;

        return Inertia::render('Cars/Show', [
            'car' => $car,
            'settings' => $settings,
            'user' => Auth::user(),
        ]);
    }
    public function edit(Car $car)
    {
        $settings = Setting::first();
        $settings->logo = $this->getLogo(image: $settings->logo);
        return Inertia::render('Cars/Edit', [
            'car' => $car,
            'settings' => $settings,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {

        $request->validate([
            'brand'       => ['required', 'min:2'],
            'model'       => ['required', 'min:1'],
            'year'        => ['required', 'numeric'],
            'price'       => ['required', 'numeric'],
            'color'       => ['required', 'string'],
            'city'        => ['required', 'string'],
            'country'     => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'carimages'       => ['nullable'],
            'carimages.*'     => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $image = $car->carimages;

        if ($request->hasFile('carimages')) {
            $paths = [];
            $oldImages = json_decode($car->carimages, true);
            foreach ($oldImages as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    File::delete(public_path($oldImage));
                }
            }
            foreach ($request->file('carimages') as $file) {
                $paths[] = $this->setImages($file, 'car');
            }
            $image = json_encode($paths);
        }
        $car->update([
            'brand'       => $request->brand,
            'model'       => $request->model,
            'year'        => $request->year,
            'price'       => $request->price,
            'color'       => $request->color,
            'city'        => $request->city,
            'country'     => $request->country,
            'description' => $request->description,
            'carimages'        => $image,
        ]);

        return Redirect::route('cars.index')->with('message', 'Car updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
            $oldImages = json_decode($car->carimages, true);
            foreach ($oldImages as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    File::delete(public_path($oldImage));
                }
            }
    
        $car->delete();
        return Redirect::back()->with('message', 'Car deleted successfully');
    }

    /// logout
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
