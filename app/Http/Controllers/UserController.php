<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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

        $request->validate([
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
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->biography = $request->biography;

        // change users image if uploaded image
        Helper::uploadFile($request, $user, 'image', uniqid(), Helper::USERS_PATH, 320, 320);

        // set default image on image delete
        if($request->remove_image == '1') {
            $user->image = '__default.jpg';
        }

        // change password
        if($request->old_password != '' && $request->new_password != '') {
            $request->validate([
                'old_password' => [
                    'current_password',
                    'required',
                    'min:5',
                ],
    
                'new_password' => [
                    'required',
                    'min:5',
                ],
            ]);

            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        return redirect()->back();
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
