<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Review;
use App\Models\Setting;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SettingsController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $setting = Setting::first();
        if ($setting) {
            $setting->logo = $this->getLogo($setting->logo);

        $imag = [];
        $website_imag = [];

        $images = json_decode($setting->images, true);
        foreach ($images as $image) {
            $imag[] = $this->getImage($image);
        }
        $website_images = json_decode($setting->website_image, true);
        foreach ($website_images as $website_image) {
            $website_imag[] = $this->getImage($website_image);
        }


        return Inertia::render('Settings/Index', [
            'settings' => [
                'id' => $setting->id,
                'website_name' => $setting->website_name,
                'logo' => $setting->logo,
                'facebook' => $setting->facebook,
                'instgram' => $setting->instgram,
                'whatsapp' => $setting->whatsapp,
                'phone' => $setting->phone,
                'mobile' => $setting->mobile,
                'titles' => json_decode($setting->titles, true),
                'images' => $imag,
                'website_image' => $website_imag,
            ],
            'translations' => trans('messages'),
            'locale' => App::getLocale(),
        ]);
    }
    return Inertia::render('Settings/Index');
    }
    public function create()
    {
        $settings = Setting::first();
        if ($settings) {
            $settings->logo = $this->getLogo($settings->logo);
        }
        return Inertia::render('Settings/Create', [
            'settings' => $settings,
            'translations' => trans('messages'),
            'locale' => App::getLocale(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'website_name' => ['required', 'min:2'],
            'facebook' => ['required', 'string'],
            'instgram' => ['required', 'string'],
            'whatsapp' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'mobile' => ['required', 'string'],
            'titles' => ['nullable'],
            'titles.*' => ['string'],
            'website_image' => ['nullable'],
            'website_image.*' => ['nullable', 'image', 'max:4096'],
            'images' => ['nullable'],
            'images.*' => ['nullable', 'image', 'max:4096'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        $images = null;
        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $this->setImages($file, 'settings');
            }
            $images = json_encode($paths);
        }

        $website_image = null;
        if ($request->hasFile('website_image')) {
            $paths = [];
            foreach ($request->file('website_image') as $file) {
                $paths[] = $this->setImages($file, 'settings');
            }
            $website_image = json_encode($paths);
        }

        $logo = null;
        if ($request->hasFile('logo')) {
            $logo = $this->setImages($request->logo, 'settings');
        }
        $titles = json_encode($request->titles);


        Setting::create([
            'website_name'   => $request->website_name,
            'facebook'       => $request->facebook,
            'instgram'       => $request->instgram,
            'whatsapp'       => $request->whatsapp,
            'phone'          => $request->phone,
            'mobile'         => $request->mobile,
            'titles'         => $titles,
            'website_image'  => $website_image,
            'images'         => $images,
            'logo'           => $logo,
        ]);

        return Redirect::route('settings.index')->with('message', 'Settings created successfully');
    }



    public function edit(Setting $settings)
    {
        $settings = Setting::first();
        if ($settings) {
            $settings->logo = $this->getLogo($settings->logo);
        }
        $settings->titles = json_decode($settings->titles);
        return Inertia::render('Settings/Edit', [
            'settings' => $settings,
            'translations' => trans('messages'),
            'locale' => App::getLocale(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $settings)
    {
        $request->validate([
            'website_name' => ['required', 'min:2'],
            'facebook' => ['required', 'string'],
            'instgram' => ['required', 'string'],
            'whatsapp' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'mobile' => ['required', 'string'],
            'titles' => ['nullable'],
            'titles.*' => ['string'],
            'website_image' => ['nullable'],
            'website_image.*' => ['nullable', 'image', 'max:4096'],
            'images' => ['nullable'],
            'images.*' => ['nullable', 'image', 'max:4096'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        $images = $settings->images;
        if ($request->hasFile('images')) {
            $paths = [];
            $oldImages = json_decode($settings->images, true);
            foreach ($oldImages as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    File::delete(public_path($oldImage));
                }
            }
            foreach ($request->file('images') as $file) {
                $paths[] = $this->setImages($file, 'settings');
            }
            $images = json_encode($paths);
        }

        $website_image = $settings->website_image;
        if ($request->hasFile('website_image')) {
            $paths = [];
            $oldImages = json_decode($settings->website_image, true);
            foreach ($oldImages as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    File::delete(public_path($oldImage));
                }
            }
            foreach ($request->file('website_image') as $file) {
                $paths[] = $this->setImages($file, 'settings');
            }
            $website_image = json_encode($paths);
        }


        $logo = $settings->logo;
        if ($request->hasFile('logo')) {
            if (file_exists(public_path($logo))) {
                File::delete(public_path($logo));
            }
            $logo = $this->setImages($request->logo, 'settings');
        }

        $settings->update([
            'website_name'       => $request->website_name,
            'facebook'       => $request->facebook,
            'instgram'        => $request->instgram,
            'whatsapp'        => $request->whatsapp,
            'phone'        => $request->phone,
            'mobile'       => $request->mobile,
            'titles'       => $request->titles,
            'website_image'        => $website_image,
            'images'        => $images,
            'logo'        => $logo,
        ]);

        return Redirect::route('settings.index')->with('message', 'settings updated successfully');
    }
}
