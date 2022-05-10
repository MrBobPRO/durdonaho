<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
                'user_id' => $user->id,
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
