<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //manually validate request to return errors for ajax request
        $failedInputs = [];
        $errorMessages = [];

        //name
        if(User::where('name', $request->name)->first()) {
            array_push($failedInputs, 'name');
            array_push($errorMessages, 'Пользователь с таким именем уже существует');
        }
        //email
        if(User::where('email', $request->email)->first()) {
            array_push($failedInputs, 'email');
            array_push($errorMessages, 'Пользователь с такой электронной почтой уже существует');
        }
        //password
        if(mb_strlen($request->password) < 5) {
            array_push($failedInputs, 'password');
            array_push($errorMessages, 'Слишком короткий пароль');
        }
        //password-confirmartion
        if($request->password != $request->password_confirmation) {
            array_push($failedInputs, 'password_confirmation');
            array_push($errorMessages, 'Пароли не совпадают');
        }

        //return erros on validation fail
        if(count($failedInputs)) {
            return [
                'validation' => 'failed',
                'failedInputs' => $failedInputs,
                'errorMessages' => $errorMessages,
            ];
        }

        //else store & login user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'role' => 'user'
        ]);

        event(new Registered($user));

        Auth::login($user);

        return [
            'validation' => 'success'
        ];
    }
}
