<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(20);

        return $users;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.profile', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = $this->validateForm($request);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput($request->except(['password', 'password_confirmation']));
        } else {
            // change data if we don't find errors
            if ($request->has('name')) {
                $user->setAttribute('name', $request->name);
            }

            if ($request->has('email')) {
                $user->setAttribute('email', $request->email);
            }

            if ($request->has('password')) {
                $user->setAttribute('password', Hash::make($request->password));
            }
        }

        // if we change the avatar
        if ($request->has('avatar_src')) {
            $filename = $user->getAttribute('email') . '_avatar.jpg';
            // save file to storage
            $user->setAttribute('avatar_src', Storage::putFileAs('public/avatars', new File($request->file('avatar_src')), $filename)); // email is unique
        }

        $user->update();

        return redirect()->route('user.show', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }

    /**
     * Валидация данных при изменении данных
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validateForm(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'sometimes|required|string|email|max:255|unique:users',
            "name" => 'sometimes|required|string|min:2|max:255',
            'password' => 'sometimes|required|string|min:8|max:16|confirmed',
        ]);
    }
}
