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
        $individual = filter_var($request->individual, FILTER_VALIDATE_BOOLEAN);

        $authors = $this->filter($request, $individual);

        if($individual) {
            $authors->withPath(route('authors.individual'));
        } else {
            $authors->withPath(route('authors.index'));
        }

        return view('components.list-inner-authors', compact('authors'));
    }

    /**
     * Filter quotes for request
     *
     * @return \Illuminate\Http\Response
     */
    public function filter($request, $individual = false)
    {
        $authors = Author::query();

        //individual 
        $authors = $authors->where('individual', $individual);

        //categories
        $category_id = $request->category_id;
        if($category_id && $category_id != '') {
            $categories = explode('-', $category_id);

            $authors = $authors->whereHas('quotes', function ($q) use ($categories) {
                $q->whereHas('categories', function ($z) use ($categories) {
                    $z->whereIn('id', $categories);
                });
            });
        }

        //keyword
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
        $quotes = QuoteController::filterSpecificAuthorsQuotes($request, $author->id);

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
