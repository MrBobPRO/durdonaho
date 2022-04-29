<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quotes(Request $request)
    {
        $quotes = QuoteController::filter($request, null, null, true);

        return view('favorites.quotes', compact('request', 'quotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authors(Request $request)
    {
        $authors = AuthorController::filter($request, null, true);

        return view('favorites.authors', compact('request', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $favorited = Favorite::where('user_id', Auth::user()->id)
                ->where('quote_id', $request->quote_id)
                ->where('author_id', $request->author_id)
                ->first();

        if($favorited) {
            $favorited->delete();

            $status = 'removed-from-favorites';
        } else {
            $favorite = new Favorite();
            $favorite->user_id = Auth::user()->id;
            $favorite->quote_id = $request->quote_id;
            $favorite->author_id = $request->author_id;
            $favorite->save();

            $status = 'added-into-favorites';
        }

        return [
            'status' => $status
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
