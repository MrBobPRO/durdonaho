<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
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

        //else store user and redirect to email verify notification page
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'role' => 'user'
        ]);

        return [
            'validation' => 'success',
            'verifyNotificationUrl' => route('verification.notice')
        ];
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            $request->session()->regenerate();

            return 'success';
        } else {
            return 'failed';
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended('/');
    }
}
