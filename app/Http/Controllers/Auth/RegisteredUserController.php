<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\setting;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Providers\RouteServiceProvider1;
use App\Traits\ImageTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    use ImageTrait;

    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $settings = setting::first();

        return Inertia::render('Auth/Register', [
            'settings' => $settings,
            'translations' => trans('messages'),
            'locale' => App::getLocale(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => 'required_with:password|same:password|min:6',
            'image' => 'image',
            'mobile' => 'required|regex:/^\+?[0-9]{7,15}$/',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'role' => 'required|string',
            Rule::in('admin', 'seller')

        ]);
        if ($request->hasFile('image')) {
            $image =  $this->setLogo($request, 'car');
        } else {
            $image = null;
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $image,
            'mobileno' => $request->mobile,
            'city' => $request->city,
            'country' => $request->country,
            'Role' => $request->role,

        ]);

        event(new Registered($user));

        Auth::login($user);
        $user = auth()->user()->Role;
        if ($user == 'seller') {
            return redirect(RouteServiceProvider::HOME);
        } else {
            return redirect(RouteServiceProvider1::HOME);
        }
    }
}
