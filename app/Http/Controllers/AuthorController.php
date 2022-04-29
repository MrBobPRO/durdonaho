<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGet(Request $request)
    {
        $authors = $this->filter($request);

        // validate query pagination path and card style due to the request route
        $individual = $request->individual;

        $cardClass = 'card_with_medium_image';

        // authors.individual route
        if($individual && $individual == 1) {
            $authors->withPath(route('authors.individual'));
        }
        // authors.index route 
        else {
            $authors->withPath(route('authors.index'));
        }

        return view('components.list-inner-authors', compact('authors', 'cardClass'));
    }

    /**
     * Filter authors for request
     * 
     * Manual parameters (manualIndividual) needed because filter function is
     * also called from many different GET routes (index page). $request may also have individual 
     * parameter, but manuals are more priority
     *
     * @return \Illuminate\Http\Response
     */
    public function filter($request, $manualIndividual = null)
    {
        $authors = Author::query();

        // Filter Query Step by step

        // 1. Individual (true only on authors.individual route)
        $individual = $manualIndividual ? $manualIndividual : $request->individual;
        if($individual && $individual != '') {
            $authors = $authors->where('individual', $individual);
        }

        // 2. Categories
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

        // 3. Search keyword
        $keyword = $request->keyword;
        if($keyword && $keyword != '') {
            $authors = $authors->where('name', 'LIKE', '%' . $keyword . '%');
        }

        $authors = $authors->orderBy('name')
                        ->paginate(6)
                        ->appends($request->except(['page', 'token', 'individual']))
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
