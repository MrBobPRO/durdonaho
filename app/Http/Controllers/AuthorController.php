<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    /**
     * Return compacted view with filtered authors (by categories, search keyword etc)
     * Used on AJAX requests by too many routes
     *
     * @return \Illuminate\Contracts\View
     */
    public function ajaxGet(Request $request)
    {
        $authors = $this->filter($request);

        // validate query pagination path and card style due to the request route
        $individual = $request->individual;
        $favorite = $request->favorite;

        $cardClass = 'card_with_medium_image';

        // authors.individual route
        if($individual && $individual == 1) {
            $authors->withPath(route('authors.individual'));
        }
        // favorite.authors route
        else if ($favorite && $favorite == 1) {
            $authors->withPath(route('favorite.authors'));
            $cardClass = 'card_with_medium_image card--full_width';
        }
        // authors.index route 
        else {
            $authors->withPath(route('authors.index'));
        }

        return view('components.list-inner-authors', compact('authors', 'cardClass'));
    }

    /**
     * Return filtered authors for the given request
     * 
     * Manual parameters (manualIndividual etc) needed because filter function is
     * also called from many different GET routes (index pages). $request may also have individual 
     * etc parameter, but manuals are more priority
     * 
     * You don`t have to include manual parameters while paginating!!! They are manually declared on each controllers functions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function filter($request, $manualIndividual = null, $manualFavorite = null)
    {
        $authors = Author::query();

        // Filter Query Step by step
        $individual = $manualIndividual ? $manualIndividual : $request->individual;
        $favorite = $manualFavorite ? $manualFavorite : $request->favorite;

        // 1. Individual (true only on authors.individual route)
        if($individual && $individual != '') {
            $authors = $authors->where('individual', $individual);
        }

        // 2. Favorite (true only on favorite.quotes route)
        else if ($favorite && $favorite != '') {
            $authorIds = Favorite::where('user_id', Auth::user()->id)->where('author_id', '!=', '')->pluck('author_id');
            $authors = $authors->whereIn('id', $authorIds);
        }

        // 3. Categories
        $category_id = $request->category_id;
        if($category_id && $category_id != '') {
            // category_id comes in string type joined by '-' because of FormData
            $categories = explode('-', $category_id);

            $authors = $authors->whereHas('quotes', function ($q) use ($categories) {
                $q->whereHas('categories', function ($z) use ($categories) {
                    $z->whereIn('id', $categories);
                });
            });
        }

        // 4. Search keyword
        $keyword = $request->keyword;
        if($keyword && $keyword != '') {
            $authors = $authors->where('name', 'LIKE', '%' . $keyword . '%');
        }

        $authors = $authors->orderBy('name')
                        ->paginate(6)
                        ->appends($request->except(['page', 'token', 'individual', 'favorite']))
                        ->fragment('authors-section');

        return $authors;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authors = $this->filter($request, false);

        return view('authors.index', compact('authors', 'request'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function individual(Request $request)
    {
        $authors = $this->filter($request, true);

        return view('authors.individual', compact('authors', 'request'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $author = Author::where('slug', $slug)->first();
        $quotes = QuoteController::filter($request, null, $author->id);

        return view('authors.show', compact('author', 'quotes', 'request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
