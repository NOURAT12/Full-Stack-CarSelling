<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\Car;
use App\Models\Product;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;



class AdminController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $cars = ProductResource::collection(Car::all());
        return Inertia::render('Cars/Index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Cars/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'min:3'],
            'image' => ['required', 'image'],
            'price' => ['required']
        ]);
        if ($request->hasFile('image')) {
            $image =  $this->setLogo($request, 'car');
            Car::create([
                'name' => $request->name,
                'path' => $image,
                'price' => $request->price,
            ]);
            return Redirect::route('cars.index')->with('message','Cars created successfully');
        }
        return Redirect::back();
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return Inertia::render('Cars/Edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'name' => ['required', 'min:3'],
            'image' => ['required', 'image'],
            'price' => ['required']
        ]);
        $image = $car->path;
        if ($request->image) {
            $image =  $this->setLogo($request, 'car');
            File::delete(public_path($car->path));
        }
        // if ($request->image) {
        //     $image =  $this->setLogo($request, 'car');
        //     File::delete(public_path($car->path));
        // }
        $car->update([
            'name' => $request->name,
            'price' => $request->price,
            'path' => $image
        ]);
        return Redirect::route('cars.index')->with('message','Car updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
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
