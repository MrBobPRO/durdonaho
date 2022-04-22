<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGet(Request $request)
    {
        //filter only specific authors quotes (authors.show route)
        $authorId = $request->author_id;
        if($authorId && $authorId != '') {
            $quotes = $this->filterSpecificAuthorsQuotes($request, $authorId);
            $quotes->withPath(route('authors.show', Author::find($authorId)->slug));

            return view('components.list-inner-quotes', compact('quotes', 'authorId'));
        //filter all authors quotes
        } else {
            $individual = filter_var($request->individual, FILTER_VALIDATE_BOOLEAN);

            $quotes = $this->filter($request, $individual);
    
            if($individual) {
                $quotes->withPath(route('quotes.individual'));
            } else {
                $quotes->withPath(route('quotes.index'));
            }

            return view('components.list-inner-quotes', compact('quotes'));
        }
    }

    /**
     * Filter quotes for request
     *
     * @return \Illuminate\Http\Response
     */
    public function filter($request, $individual = false)
    {
        $quotes = Quote::query();

        //individual 
        $authorIds = Author::where('individual', $individual)->pluck('id');
        $quotes = $quotes->whereIn('author_id', $authorIds);

        //categories
        $category_id = $request->category_id;
        if($category_id && $category_id != '') {
            $categories = explode('-', $category_id);
            $quotes = $quotes->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('id', $categories);
            });
        }

        //keyword
        $keyword = $request->keyword;
        if($keyword && $keyword != '') {
            $quotes = $quotes->where('body', 'LIKE', '%' . $keyword . '%');
        }

        $quotes = $quotes->latest()
                        ->paginate(6)
                        ->appends($request->except(['page', 'token', 'individual']))
                        ->fragment('quotes-section');

        return $quotes;
    }

    /**
     * Filter quotes for authors show route
     *
     * @return \Illuminate\Http\Response
     */
    public static function filterSpecificAuthorsQuotes($request, $authorId)
    {
        $quotes = Quote::query();

        $quotes = $quotes->where('author_id', $authorId);

        //categories
        $category_id = $request->category_id;
        if($category_id && $category_id != '') {
            $categories = explode('-', $category_id);
            $quotes = $quotes->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('id', $categories);
            });
        }

        //keyword
        $keyword = $request->keyword;
        if($keyword && $keyword != '') {
            $quotes = $quotes->where('body', 'LIKE', '%' . $keyword . '%');
        }

        $quotes = $quotes->latest()
                        ->paginate(6)
                        ->appends($request->except(['page', 'token', 'authorId']))
                        ->fragment('quotes-section');

        return $quotes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $quotes = $this->filter($request, false);

        return view('quotes.index', compact('quotes', 'request'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function individual(Request $request)
    {
        $quotes = $this->filter($request, true);

        return view('quotes.individual', compact('quotes', 'request'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function top()
    {
        $quotes = Quote::withCount('likes')->orderBy('likes_count', 'desc')->take(20)->paginate(10)->fragment('quotes-section');

        return view('quotes.top', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
