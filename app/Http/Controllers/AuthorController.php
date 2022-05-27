<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Author;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    // used while generating route names in dashboard
    const MODEL_SHORTCUT = 'authors';
    // used while uploading images
    const IMAGE_PATH = 'img/authors';

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
     * Display a listing of the resource in dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboardIndex(Request $request)
    {
        // used while generating route names
        $modelShortcut = self::MODEL_SHORTCUT;

        // for search & counting on index pages
        $allItems = Author::select('name as title', 'id')->orderBy('title')->get();

        // Default parameters for ordering
        $orderBy = $request->orderBy ? $request->orderBy : 'name';
        $orderType = $request->orderType ? $request->orderType : 'asc';
        $activePage = $request->page ? $request->page : 1;

        $items = Author::orderBy($orderBy, $orderType)
                ->withCount('quotes')
                ->paginate(30, ['*'], 'page', $activePage)
                ->appends($request->except('page'));

        return view('dashboard.authors.index', compact('modelShortcut', 'allItems', 'items', 'orderBy', 'orderType', 'activePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // used while generating route names
        $modelShortcut = self::MODEL_SHORTCUT;

        $users = User::orderBy('name')->select('name', 'id')->get();

        return view('dashboard.authors.create', compact('modelShortcut', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $validationRules = [
            'name' => [
                'required',
                Rule::unique('authors'),
            ],
        ];

        $validationMessages = [
            "name.unique" => "Автор с таким названием уже существует !",
        ];

        Validator::make($request->all(), $validationRules, $validationMessages)->validate();

        // store quote
        $author = new Author();
        $fields = ['name', 'user_id', 'biography', 'popular', 'individual'];
        Helper::fillModelColumns($author, $fields, $request);
        $author->slug = Helper::generateUniqueSlug($request->name, Author::class);

        Helper::uploadModelsFile($request, $author, 'image', $author->slug, self::IMAGE_PATH, 300);

        $author->save();

        return redirect()->route('authors.dashboard.index');
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
        $modelShortcut = self::MODEL_SHORTCUT;

        $item = Author::find($id);
        $users = User::orderBy('name')->select('name', 'id')->get();

        return view('dashboard.authors.edit', compact('modelShortcut', 'item', 'users'));
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
        $author = Author::find($request->id);

        // validate request
        $validationRules = [
            'name' => [
                'required',
                Rule::unique('authors')->ignore($author->id),
            ],
        ];

        $validationMessages = [
            "name.unique" => "Автор с таким названием уже существует !",
        ];

        Validator::make($request->all(), $validationRules, $validationMessages)->validate();

        // update author
        $fields = ['name', 'user_id', 'biography', 'popular', 'individual'];
        Helper::fillModelColumns($author, $fields, $request);
        $author->slug = Helper::generateUniqueSlug($request->name, Author::class, $author->id);

        Helper::uploadModelsFile($request, $author, 'image', $author->slug, self::IMAGE_PATH, 300);

        $author->save();

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
            $item = Author::find($id);
            $item->delete();
        }
        
        return redirect()->route('authors.dashboard.index');
    }
}
