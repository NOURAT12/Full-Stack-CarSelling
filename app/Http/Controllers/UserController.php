<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Car;
use App\Models\Review;
use App\Models\Setting;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function results(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type');

        $carQuery = Car::query();

        if ($type === 'year') {
            $carQuery->where('year', 'like', "%$query%");
        } else {
            $carQuery->where('brand', 'like', "%$query%");
        }

        $cars = $carQuery->paginate(8);

        foreach ($cars as $car) {
            $images = json_decode($car->carimages, true);
            $car->image = $this->getLogo($images[0]);
        }

        $settings = Setting::first();
        if ($settings) {
            $settings->logo = $this->getLogo($settings->logo);
        }
        return Inertia::render('Cars/Index', [
            'settings' => $settings,
            'cars' => $cars,
        ]);
    }

    public function create_reviews(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:2'],
            'phone' => ['required', 'min:2'],
            'is_public' => ['required'],
            'content' => ['required', 'string'],
            'car_id' => ['required' , 'exists:cars,id'],
        ]);


        Review::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'is_public' => $request->is_public,
            'content' => $request->content,
            'status' => 2,
            'car_id' => $request->car_id,
        ]);

        return Redirect::back()->with('message', 'Review  added successfully.');
    }
    public function homeUser()
    {

        $ads = Ad::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();
        $latestCars = Car::query()->where('sold', "0")->latest()->take('6')->get();
        $randomCars = Car::where('sold', "0")->get();
        if(count($randomCars)>2){
            $randomCars=$randomCars->random(3);
        }

        $soldCars = Car::query()->where('sold', "1")->latest()->take('6')->get();
        $reviews = Review::query()->where('status', 1)->latest()->take('6')->get();

        foreach ($latestCars as $latestCar) {
            $images = json_decode($latestCar->carimages, true);
            $latestCar->image = $this->getLogo($images[0]);
        }
        foreach ($randomCars as $randomCar) {
            $images = json_decode($randomCar->carimages, true);
            $randomCar->image = $this->getLogo($images[0]);
        }
        foreach ($soldCars as $soldCar) {
            $images = json_decode($soldCar->carimages, true);
            $soldCar->image = $this->getLogo($images[0]);
        }
        foreach ($ads as $ad) {
            $ad->image = $this->getLogo($ad->image);
        }

        $settings = Setting::first();
        if ($settings) {
            $settings->logo = $this->getLogo($settings->logo);
        }
        $images = json_decode($settings->images, true);
        foreach ($images as $image) {
            $imag[] = $this->getImage($image);
        }
        $settings->images = $imag;
        $settings->titles = json_decode($settings->titles, true);
        return Inertia::render('Home', [
            'settings' => $settings,
            'ads' => $ads,
            'latestCars' => $latestCars,
            'randomCars' => $randomCars,
            'soldCars' => $soldCars,
            'reviews' => $reviews,
            'translations' => trans('messages'),
            'locale' => App::getLocale(),
        ]);
    }

    public function incrementHit($id)
    {
        $ad = Ad::findOrFail($id);
        $ad->hit += 1;
        $ad->save();

        return response()->json(['success' => true]);
    }
}
