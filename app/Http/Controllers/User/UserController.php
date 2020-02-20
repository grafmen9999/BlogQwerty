<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Manager\FileManager;
use Illuminate\Http\Request;
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
    public function show($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateForm($request);

        $user = User::findOrFail($id);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput($request->except(['password', 'password_confirmation']));
        } else {
            // change data if we don't find errors
            $user->setAttribute('name', $request->name ?? $user->name);
            
            if ($request->has('email')) {
                $directory = config('dir_image_avatar', 'image/avatars/');
                $oldName = $directory . $user->email . '_avatar.jpg';
                $newName = $directory . $request->email . '_avatar.jpg';
                $user->setAttribute('email', $request->email);

                (new FileManager())->rename($oldName, $newName);
            }

            if ($request->has('password')) {
                $user->setAttribute('password', Hash::make($request->password));
            }
        }

        // if we change the avatar
        // Temporary solution. I think how to solve it.
        if ($request->has('avatar_src')) {
            $directory = config('dir_image_avatar', 'image/avatars/');
            $filename = $user->email . '_avatar.jpg';

            (new FileManager())->create($directory, $filename, $request->file('avatar_src'));
        }

        $user->update($request->all());

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
