<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $settings = Setting::first();
        if ($settings) {
            $settings->logo = $this->getLogo($settings->logo);
        }
        return Inertia::render('Welcome', [
            'settings' => $settings,
            'translations' => trans('messages'),
            'locale' => App::getLocale(),
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
        if ($settings) {
            $settings->logo = $this->getLogo($settings->logo);
        }
        return Inertia::render('Seller/Dashboard', [
            'settings' => $settings,
            'cars' => $cars,
            'translations' => trans('messages'),
            'locale' => App::getLocale(),
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
        if ($settings) {
            $settings->logo = $this->getLogo($settings->logo);
        }
        return Inertia::render('Admin/Dashboard', [
            'settings' => $settings,
            'cars' => $cars,
            'translations' => trans('messages'),
            'locale' => App::getLocale(),
        ]);
    }
}
