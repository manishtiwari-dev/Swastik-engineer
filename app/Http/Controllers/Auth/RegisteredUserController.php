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
        return view('backend.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
                'name' => ['required', 'string'],
                'email' => ['required', 'string', 'email','unique:'.User::class],
                'password' => ['required','min:8','confirmed'],
                'password_confirmation' => ['required'],
            ],
        
            [
                'name.required' =>localize('Please enter name.'),
                'name.string' =>localize('Please enter valid name.'),

                'email.email'=>localize('Please enter email.'),
                'email.string'=>localize('Please enter valid email.'),
                'email.unique'=>localize('Please alredy registerd.'),
                'email.required' => localize('Please enter email.'),

                'password.required' => localize('Please enter password.'),
                'password.min' => localize('Please enter minimum 8 character.'),
                'password.confirmed' =>localize('Password and confirm password not matched.') ,

                'password_confirmation.required' => localize('Please enter confirm password.'),
              
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
