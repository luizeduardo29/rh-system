<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'initials' => ['required','string', 'max:5'],
            'birth' => ['required', 'date'],
            'naturalness' => ['required'],
            'nationality' => ['required'],
            'gender' => ['required'],
            'maritalStatus' => ['required'],
            'photo' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'initials' =>$request->initials,
            'birth' => $request->birth,
            'naturalness' => $request->naturalness,
            'nationality' => $request->nationality,
            'photo' => $request->file('photo')->store('users/profile'),
            'gender' => $request->gender,
            'maritalStatus' => $request->maritalStatus,
        ]);

        $user->contacts()->createMany($request->contacts);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
