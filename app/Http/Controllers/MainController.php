<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Quote;
use Illuminate\Http\Request;

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
