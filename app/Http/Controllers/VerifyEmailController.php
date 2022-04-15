<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function notice()
    {
        return view('auth.verify-email-notification');
    }
}
