<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.profile', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $is_change = false;

        $validator = $this->validateForm($request);

        if (!is_null($validator)) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->except(['password', 'password_confirmation']));
        } else {
            $is_change = true;
            // change data if we don't find errors
            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->password = Hash::make($request->password) ?? $user->password;
        }

        // if we change the avatar
        if (isset($request->avatar_src)) {
            $is_change = true;

            $filename = $user->email . '_avatar.jpg';
            // save file to storage
            $user->avatar_src = Storage::putFileAs('public/avatars', new File($request->file('avatar_src')), $filename); // email is unique
        }

        if ($is_change) {
            $user->update();
        }

        return redirect()->route('user.show', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // $user->delete();
    }

    private function validateForm(Request $request)
    {
        if (isset($request->name)) {
            $validator = Validator::make(['name' => $request->name], [
                "name" => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return $validator;
            }
        }

        if (isset($request->email)) {
            $validator = Validator::make(['email' => $request->email], [
                'email' => 'required|string|email|max:255|unique:users'
            ]);

            if ($validator->fails()) {
                return $validator;
            }
        }

        if (isset($request->password) || $request->password_confirmation) {
            $validator = Validator::make([
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation
            ], [
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return $validator;
            }
        }

        return null;
    }
}
