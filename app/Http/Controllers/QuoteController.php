<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Favorite;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    /**
     * Return compacted view with filtered quotes (by categories, userId, authorId etc)
     * Used on AJAX requests by too many routes
     *
     * @return \Illuminate\Contracts\View
     */
    public function ajaxGet(Request $request)
    {
        $quotes = $this->filter($request);

        // validate query pagination path and card style due to the requests route
        $authorId = $request->author_id;
        $individual = $request->individual;
        $favorite = $request->favorite;
        $userId = $request->user_id;

        $cardClass = 'card_with_small_image';

        // authors.show route
        if ($authorId && $authorId != '') {
            $quotes->withPath(route('authors.show', Author::find($authorId)->slug));
        }
        // quotes.individual route
        else if ($individual && $individual == 1) {
            $quotes->withPath(route('quotes.individual'));
        }
        // favorite.quotes route
        else if ($favorite && $favorite == 1) {
            $quotes->withPath(route('favorite.quotes'));
            $cardClass = 'card_with_small_image card--full_width';
        }
        // users.current.quotes route
        else if ($userId && $userId != '' && Auth::check() && $userId == Auth::user()->id) {
            $quotes->withPath(route('users.current.quotes'));
            $cardClass = 'card_with_small_image card--full_width';

            // display edit button for quotes
            $showEditButton = true;
            // return view with compacted showEditButton
            return view('components.list-inner-quotes', compact('quotes', 'cardClass', 'showEditButton'));
        }
        // users.quotes route
        else if ($userId && $userId != '') {
            $quotes->withPath(route('users.quotes', User::find($userId)->slug));
            $cardClass = 'card_with_small_image card--full_width';
        }
        //quotes.index route
        else {
            $quotes->withPath(route('quotes.index'));
        }

        return view('components.list-inner-quotes', compact('quotes', 'cardClass'));
    }

    /**
     * Return filtered quotes for the given request
     * 
     * Manual parameters (manualIndividual && manualAuthorId etc) needed because filter function is
     * also called from many different GET routes (index pages). $request may also have individual
     * & author_id & favorite etc parameters, but manuals are more priority
     * 
     * You don`t have to include manual parameters while paginating!!! They are manually declared on each controllers functions
     * 
     * Only approvoed quotes (by admin) will be taken
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function filter($request, $manualIndividual = null, $manualAuthorId = null, $manualFavorite = null, $manualUserId = null)
    {
        $quotes = Quote::query();

        // Filter Query Step by step
        $authorId = $manualAuthorId ? $manualAuthorId : $request->author_id;
        $individual = $manualIndividual ? $manualIndividual : $request->individual;
        $favorite = $manualFavorite ? $manualFavorite : $request->favorite;
        $userId = $manualUserId ? $manualUserId : $request->user_id;

        // 1. Only approved quotes (by admin) will be taken
        $quotes = $quotes->where('approved', true);

        // 2. Specific Authors quotes (valid only on authors.show route) 
        if ($authorId && $authorId != '') {
            $quotes = $quotes->where('author_id', $authorId);
        } 

        // 3. Favorite (true only on favorite.quotes route)
        else if ($favorite && $favorite != '') {
            $quoteIds = Favorite::where('user_id', Auth::user()->id)->where('quote_id', '!=', '')->pluck('quote_id');
            $quotes = $quotes->whereIn('id', $quoteIds);
        }

        // 4. Individual (true only on quotes.individual route)
        else if ($individual && $individual != '') {
            $authorIds = Author::where('individual', true)->pluck('id');
            $quotes = $quotes->whereIn('author_id', $authorIds);
        }

        // 5. Specific users quotes (valid only on users.quotes && users.current.quotes route) 
        else if ($userId && $userId != '') {
            $quotes = $quotes->where('user_id', $userId);
        }

        // 6. Categories
        $category_id = $request->category_id;
        if ($category_id && $category_id != '') {
            // category_id comes in string type joined by '-' because of FormData
            $categories = explode('-', $category_id);
            $quotes = $quotes->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('id', $categories);
            });
        }

        // 7. Search keyword
        $keyword = $request->keyword;
        if ($keyword && $keyword != '') {
            $quotes = $quotes->where('body', 'LIKE', '%' . $keyword . '%');
        }

        $quotes = $quotes->latest()
            ->paginate(6)
            ->appends($request->except(['page', 'token', 'individual', 'author_id', 'favorite', 'user_id']))
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
