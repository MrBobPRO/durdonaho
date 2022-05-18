<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Mail\EmailVerifyNotification;
use App\Models\Author;
use App\Models\Category;
use App\Models\Manual;
use App\Models\Quote;
use App\Models\Source;
use App\Models\User;
use App\Models\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::where('slug', $slug)->first();

        return view('users.show', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();

        return view('users.profile', compact('user'));
    }

    /**
     * Show users quotes
     *
     * @return \Illuminate\Http\Response
     */
    public function quotes(Request $request, $slug)
    {
        $userId = User::where('slug', $slug)->first()->id;

        // redirect to users.current.quotes route if $userId equals to authenticated users id
        if(Auth::check() && $userId == Auth::user()->id) {
            return redirect()->route('users.current.quotes');
        }

        $quotes = QuoteController::filter($request, null, null, null, $userId);

        return view('users.quotes', compact('quotes', 'userId', 'request'));
    }

    /**
     * Show users quotes
     *
     * @return \Illuminate\Http\Response
     */
    public function currentUsersQuotes(Request $request)
    {
        $userId = Auth::user()->id;
        $quotes = QuoteController::filter($request, null, null, null, $userId);

        return view('users.current-users-quotes', compact('quotes', 'userId', 'request'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validationRules = [
            'name' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],

            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore($user->id),
            ],

            'gender' => [
                'required',
                Rule::in(['male', 'female']),
            ]
        ];

        $passwordValidationRules = [
            'old_password' => [
                'current_password',
                'required',
                'min:5',
            ],

            'new_password' => [
                'required',
                'min:5',
            ],
        ];

        // merge validation rules while requesting for password change
        if($request->old_password != '' ) {
            $validationRules = array_merge($validationRules, $passwordValidationRules);
        }

        $request->validate($validationRules);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->biography = $request->biography;

        // change users image if uploaded image
        Helper::uploadFile($request, $user, 'image', uniqid(), Helper::USERS_PATH, 320, 320);

        // set default image on image delete
        if($request->remove_image == '1') {
            $user->image = '__default.jpg';
        }

        // force email verification on email change
        if($request->email != $user->email) {
            $user->email = $request->email;
            $user->verified_email = false;

            //send email veify notification
            $token = str()->random(64);

            VerifyEmail::create([
                'email' => $user->email,
                'token' => $token
            ]);

            Mail::to($request->email)->send(new EmailVerifyNotification($token));
        }

        // change password
        if($request->old_password != '' ) {
            $user->password = bcrypt($request->new_password);

            // logout user
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $user->save();

            return redirect()->route('home');
        }

        $user->save();

        return redirect()->back();
    }

    public function createQuote()
    {
        $sources = Source::orderBy('title')->select('title')->get();
        $authors = Author::orderBy('name')->select('name')->get();
        $categories = Category::orderBy('title')->select('title')->get();

        return view('users.create-quote', compact('authors', 'sources', 'categories'));
    }

    public function storeQuote(Request $request)
    {
        // returb rerror if there is already a quote very similar to the createing quote
        $body = $request->body;
        $quotes = Quote::pluck('body');
        foreach($quotes as $quote) {
            similar_text($body, $quote, $percentage);
            if($percentage > 90) {
                return redirect()->back()->with(['status' => 'similar-quote-error', 'similarQuote' => $quote])->withInput();
            }
        };

        // else store quote
        $quote = new Quote();
        $quote->body = $request->body;
        $quote->popular = false;
        $quote->verified = false;
        $quote->approved = false;
        $quote->user_id = Auth::user()->id;

        // get id for newly creating quote
        $statement = DB::select("show table status like 'quotes'");
        $quoteId = $statement[0]->Auto_increment;

        // validate source
        $requestedSource = $request->source;
        $source = Source::where('title', $requestedSource)->first();
        if($source) {
            $quote->source_id = $source->id;
        } else {
            $manual = new Manual();
            $manual->quote_id = $quoteId;
            $manual->key = 'source';
            $manual->value = $requestedSource;
            $manual->save();
        }

        // validate author
        $requestedAuthor = $request->author;
        $author = Author::where('name', $requestedAuthor)->first();
        if($author) {
            $quote->author_id = $author->id;
        } else {
            $quote->author_id = 0;
            $manual = new Manual();
            $manual->quote_id = $quoteId;
            $manual->key = 'author';
            $manual->value = $requestedAuthor;
            $manual->save();
        }

        // save quote before attaching categories
        $quote->save();

        // validate categories
        $requestedCategories = $request->categories;
        // used to store nonexistent categories
        $nonExistentCategories = [];

        foreach($requestedCategories as $requestedCategory) {
            $category = Category::where('title', $requestedCategory)->first();
            if($category) {
                $quote->categories()->attach($category->id);
            } else {
                array_push($nonExistentCategories, $requestedCategory);
            }
        }

        // create manual for categories
        if(count($nonExistentCategories)) {
            $manual = new Manual;
            $manual->quote_id = $quoteId;
            $manual->key = 'categories';
            $manual->value = implode(', ', $nonExistentCategories);
            $manual->save();
        }

        return redirect()->back()->with(['status' => 'success']);
    }

    public function editQuote($id)
    {
        dd(Quote::find($id));
        $sources = Source::orderBy('title')->select('title')->get();
        $authors = Author::orderBy('name')->select('name')->get();
        $categories = Category::orderBy('title')->select('title')->get();

        return view('users.create-quote', compact('authors', 'sources', 'categories'));
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