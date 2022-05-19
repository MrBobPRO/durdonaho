<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Quote;
use App\Models\Report;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        $latestQuotes = Quote::where('approved', true)->latest()->take(8)->get();
        $popularQuotes = Quote::where('popular', true)->where('approved', true)->inRandomOrder()->take(8)->get();
        $popularAuthors = Author::where('popular', true)->inRandomOrder()->take(8)->get();

        return view('home.index', compact('latestQuotes', 'popularQuotes', 'popularAuthors'));
    }

    public function reportBug(Request $request)
    {
        $report = new Report();
        $report->user_id = auth()->user()->id;
        $report->quote_id = $request->quote_id;
        $report->author_id = $request->author_id;
        $report->message = $request->message;
        $report->save();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $authors = Author::where("name", "LIKE", "%" . $keyword . "%")
                        ->orWhere("biography", "LIKE", "%" . $keyword . "%")
                        ->orderBy("name")->get();

        $quotes = Quote::where(function ($q) use ($keyword) {
                            $q->whereHas('author', function ($a) use ($keyword) {
                                    $a->where("name", "LIKE", "%" . $keyword . "%"); })
                            ->where('approved', true);
                        })

                        ->orWhere(function ($q) use ($keyword) {
                            $q->where("body", "LIKE", "%" . $keyword . "%")
                            ->where('approved', true);
                        })
                                
                        ->latest()->get();

        return view("search.index", compact("keyword", "authors", "quotes"));
    }
}
