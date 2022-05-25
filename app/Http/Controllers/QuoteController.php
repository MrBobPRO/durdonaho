<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Author;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Quote;
use App\Models\Source;
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
     * Display a listing of the resource in dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboardIndex(Request $request)
    {
        // used while generating route names
        $modelShortcut = 'quotes';

        // for search & counting on index pages
        $allItems = Quote::select('body as title', 'id')->approved()->orderBy('title')->get();

        // Default parameters for ordering
        $orderBy = $request->orderBy ? $request->orderBy : 'created_at';
        $orderType = $request->orderType ? $request->orderType : 'desc';
        $activePage = $request->page ? $request->page : 1;

        // orderby Categories
        if($orderBy == 'category_titles') {
            $items = Quote::selectRaw('group_concat(categories.title order by categories.title asc) as category_titles, quotes.*') 
                    ->join('category_quote', 'quotes.id', '=', 'category_quote.quote_id')
                    ->join('categories', 'categories.id', '=', 'category_quote.category_id')
                    ->groupBy('quote_id')
                    ->approved()
                    ->orderBy($orderBy, $orderType)
                    ->paginate(30, ['*'], 'page', $activePage)
                    ->appends($request->except('page'));
        }

        // orderBy Author name 
        else if ($orderBy == 'author_name') {
            $items = Quote::join('authors', 'quotes.author_id', '=', 'authors.id')
                    ->select('quotes.*', 'authors.name as author_name')
                    ->approved()
                    ->orderBy($orderBy, $orderType)
                    ->paginate(30, ['*'], 'page', $activePage)
                    ->appends($request->except('page'));
        }

        else {
            $items = Quote::approved()->orderBy($orderBy, $orderType)
                    ->paginate(30, ['*'], 'page', $activePage)
                    ->appends($request->except('page'));
        }

        return view('dashboard.quotes.index', compact('modelShortcut', 'allItems', 'items', 'orderBy', 'orderType', 'activePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // used while generating route names
        $modelShortcut = 'quotes';

        $authors = Author::orderBy('name')->select('name', 'id')->get();
        $categories = Category::orderBy('title')->select('title', 'id')->get();
        $sources = Source::orderBy('title')->select('title', 'id')->get();
        $users = User::orderBy('name')->select('name', 'id')->get();

        return view('dashboard.quotes.create', compact('modelShortcut', 'authors', 'categories', 'sources', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return rerror if there is already a quote very similar to the createing quote
        $body = $request->body;
        $quotes = Quote::approved()->pluck('body');
        foreach($quotes as $quote) {
            similar_text($body, $quote, $percentage);
            if($percentage > 85) {
                return redirect()->back()->withInput()->withErrors(['Похожая цитата уже существует : ' . $quote]);
            }
        };

        // store quote
        $quote = new Quote();
        $fields = ['body', 'author_id', 'source_id', 'user_id', 'popular'];
        Helper::fillModelColumns($quote, $fields, $request);

        $quote->verified = true;
        $quote->approved = true;
        $quote->save();

        $quote->categories()->attach($request->categories);

        return redirect()->route('dashboard.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // used while generating route names
        $modelShortcut = 'quotes';

        $item = Quote::find($id);

        $authors = Author::orderBy('name')->select('name', 'id')->get();
        $categories = Category::orderBy('title')->select('title', 'id')->get();
        $sources = Source::orderBy('title')->select('title', 'id')->get();
        $users = User::orderBy('name')->select('name', 'id')->get();

        return view('dashboard.quotes.edit', compact('modelShortcut', 'item', 'authors', 'categories', 'sources', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return rerror if there is already a quote very similar to the createing quote
        $body = $request->body;
        $quotes = Quote::approved()->where('id', '!=', $request->id)->pluck('body');
        foreach($quotes as $quote) {
            similar_text($body, $quote, $percentage);
            if($percentage > 85) {
                return redirect()->back()->withInput()->withErrors(['Похожая цитата уже существует : ' . $quote]);
            }
        };

        // update quote
        $quote = Quote::find($request->id);
        $fields = ['body', 'author_id', 'source_id', 'user_id', 'popular'];
        Helper::fillModelColumns($quote, $fields, $request);
        $quote->save();

        // reattach categories
        $quote->categories()->detach();
        $quote->categories()->attach($request->categories);

        return redirect()->back();
    }

    /**
     * Request for deleting items by id may come in integer type (single item destroy form) 
     * or in array type (multiple item destroy form)
     * That`s why we need to get them in array type and delete them by loop
     *
     * Checkout Model Boot methods deleting function 
     * Models relations also deleted on deleting function of Models Boot method
     * 
     * @param  int/array  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        $ids = (array) $request->id;
        
        foreach($ids as $id) {
            $item = Quote::find($id);
            $item->delete();
        }
        
        return redirect()->route('dashboard.index');
    }
}
