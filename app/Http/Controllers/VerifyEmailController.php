<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function notice()
    {
        if(!Auth::check()) {
            return redirect()->route('home');
        }

        $user = Auth::user();
        if($user->verified_email) {
            return redirect()->route('home');
        } else {
            return view('auth.verify-email-notification');
        }
    }

    public function verify($token)
    {
        $user = VerifyEmail::where('token', $token)->first() ? VerifyEmail::where('token', $token)->first()->user : null;

        if(!$user) {
            $message = 'Неверный запрос, или ваш запрос уже истёк! Пожалуйста, запросите новое письмо по странице <a href="' . route('verification.notice') . '">' . route('verification.notice') . '</a>';
        } elseif($user->verified_email) {
            $message = 'Вы уже подтвердили свою электронную почту!';
        } elseif(!$user->verified_email) {
            $user->verified_email = true;
            $user->save();
            $message = 'Вы успешно подтвердили свою электронную почту!';
        }

        return view('auth.verify-email-verification', compact('message'));
    }
}