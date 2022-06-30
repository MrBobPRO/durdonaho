<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerifyNotification;
use App\Models\User;
use App\Models\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        // check valid token
        $email = VerifyEmail::where('token', $token)->first() ? VerifyEmail::where('token', $token)->first()->email : null;
        $user = $email ? User::where('email', $email)->first() : null; 

        // check if user has logged in and already verified email
        if(Auth::check() && Auth::user()->verified_email) {
            return redirect()->route('home');
        
        // else verify users email if token is VALID 
        } elseif($user) {
            $user->verified_email = true;
            $user->save();
            $message = 'Шумо бомуваффақият имейли худро тасдиқ кардед!';

            VerifyEmail::where('token', $token)->delete();

        // else if token is INVALID
        } elseif(!$user) {
            $message = 'Неверный запрос! Возможно вы уже подтвердили свою электронную почту! Если это не так, то вы можете запросить новое письмо по ссылке <a href="' . route('verification.notice') . '">' . route('verification.notice') . '</a>. Ссылка доступна только авторизированным пользователям!';
        }

        return view('auth.verify-email-verification', compact('message'));
    }

    public function resendEmail(Request $request)
    {
        $user = Auth::user();
        $token = str()->random(64);

        $verification = new VerifyEmail();
        $verification->email = $user->email;
        $verification->token = $token;
        $verification->save();

        Mail::to($user->email)->send(new EmailVerifyNotification($token));

        return 'success';
    }
}