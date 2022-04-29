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
        $quotes = $this->filter($request);

        // validate query pagination path and card style due to the request route
        $authorId = $request->author_id;
        $individual = $request->individual;

        $cardClass = 'card_with_small_image';

        // authors.show route
        if ($authorId && $authorId != '') {
            $quotes->withPath(route('authors.show', Author::find($authorId)->slug));
        }
        // quotes.individual route
        else if ($individual && $individual == 1) {
            $quotes->withPath(route('quotes.individual'));
        }
        //quotes.index route
        else {
            $quotes->withPath(route('quotes.index'));
        }

        return view('components.list-inner-quotes', compact('quotes', 'cardClass'));
    }

    /**
     * Filter quotes for request
     * 
     * Manual parameters (manualIndividual && manualAuthorId) needed because filter function 
     * also called from many different GET routes (index page). $request may also have individual and 
     * author_id parameters, but manuals are more priority
     *
     * @return \Illuminate\Http\Response
     */
    public static function filter($request, $manualIndividual = null, $manualAuthorId = null)
    {
        $quotes = Quote::query();
        // Filter Query Step by step

        // 1. Specific Authors quotes (valid only on authors.show route) 
        $authorId = $manualAuthorId ? $manualAuthorId : $request->author_id;
        if ($authorId && $authorId != '') {
            $quotes = $quotes->where('author_id', $authorId);

            // 2. Individual (true only on quotes.individual route)
        } else {
            $individual = $manualIndividual ? $manualIndividual : $request->individual;
            if ($individual && $individual != '') {
                $authorIds = Author::where('individual', true)->pluck('id');
                $quotes = $quotes->whereIn('author_id', $authorIds);
            }
        }

        // 3. Categories
        $category_id = $request->category_id;
        if ($category_id && $category_id != '') {
            // category_id comes in string type joined by '-' because of FormData
            $categories = explode('-', $category_id);
            $quotes = $quotes->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('id', $categories);
            });
        }

        // 4. Search keyword
        $keyword = $request->keyword;
        if ($keyword && $keyword != '') {
            $quotes = $quotes->where('body', 'LIKE', '%' . $keyword . '%');
        }

        $quotes = $quotes->latest()
            ->paginate(6)
            ->appends($request->except(['page', 'token', 'individual', 'author_id']))
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
