<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SourceController extends Controller
{
    // used while generating route names in dashboard
    const MODEL_SHORTCUT = 'sources';

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
        $allItems = Source::select('title', 'id')->orderBy('title')->get();

        // Default parameters for ordering
        $orderBy = $request->orderBy ? $request->orderBy : 'title';
        $orderType = $request->orderType ? $request->orderType : 'asc';
        $activePage = $request->page ? $request->page : 1;

        $items = Source::orderBy($orderBy, $orderType)
                ->withCount('quotes')
                ->paginate(30, ['*'], 'page', $activePage)
                ->appends($request->except('page'));

        return view('dashboard.sources.index', compact('modelShortcut', 'allItems', 'items', 'orderBy', 'orderType', 'activePage'));
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

        return view('dashboard.sources.create', compact('modelShortcut'));
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
            'title' => [
                'required',
                Rule::unique('sources'),
            ],
        ];

        $validationMessages = [
            "title.unique" => "Источник с таким заголовком уже существует !",
        ];

        Validator::make($request->all(), $validationRules, $validationMessages)->validate();

        // store source
        $source = new Source();
        $source->title = $request->title;
        $source->save();

        return redirect()->route('sources.dashboard.index');
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

        $item = Source::find($id);

        return view('dashboard.sources.edit', compact('modelShortcut', 'item'));
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
        $source = Source::find($request->id);

        // validate request
        $validationRules = [
            'title' => [
                'required',
                Rule::unique('sources')->ignore($source->id),
            ],
        ];

        $validationMessages = [
            "title.unique" => "Источник с таким заголовком уже существует !",
        ];

        Validator::make($request->all(), $validationRules, $validationMessages)->validate();

        // update source
        $source->title = $request->title;
        $source->save();

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
            Source::find($id)->delete();
        }
        
        return redirect()->route('sources.dashboard.index');
    }
}
