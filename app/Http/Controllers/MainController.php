<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerifyNotification;
use App\Models\Author;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function home()
    {
        $latestQuotes = Quote::latest()->take(8)->get();
        $popularQuotes = Quote::where('popular', true)->inRandomOrder()->take(8)->get();
        $popularAuthors = Author::where('popular', true)->inRandomOrder()->take(8)->get();

        return view('home.index', compact('latestQuotes', 'popularQuotes', 'popularAuthors'));
    }
}
