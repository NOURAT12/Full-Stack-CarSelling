<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Traits\ImageTrait;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $settings = Setting::first();

        return Inertia::render('Welcome', [
            'settings' => $settings,
        ]);
    }
    public function sellerDash()
    {
        $cars = Car::query()->paginate(8);
        foreach ($cars as $car) {
            $images = json_decode($car->carimages, true);
            $car->image = $this->getLogo($images[0]);
        }

        $settings = Setting::first();
        $settings->logo = $this->getLogo(image: $settings->logo);
        return Inertia::render('Seller/Dashboard', [
            'settings' => $settings,
            'cars' => $cars,
        ]);
    }

    public function adminDash()
    {
        $cars = Car::query()->paginate(8);
        foreach ($cars as $car) {
            $images = json_decode($car->carimages, true);
            $car->image = $this->getLogo($images[0]);
        }

        $settings = Setting::first();
        $settings->logo = $this->getLogo(image: $settings->logo);
        return Inertia::render('Admin/Dashboard', [
            'settings' => $settings,
            'cars' => $cars,
        ]);
    }
}
