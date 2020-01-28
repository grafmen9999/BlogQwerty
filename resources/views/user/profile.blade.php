@extends('layouts.app')

@section('body-class', 'body')

@section('content')
<div class="container emp-profile">
    <form method="post" action="{{ route('user.update', ['user' => $user]) }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    <img src="{{ $user->avatar_src }}" alt="Avatar"/>
                    @if ($user->id == Auth::id())
                    <div class="file btn btn-lg btn-primary">
                        Change Photo
                        <input type="file" name="avatar_src"/>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                    <h5>
                        {{ $user->name }}
                    </h5>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                        </li>
                    </ul>
                </div>
            </div>
            @if ($user->id == Auth::id())
            <div class="col-md-2">
                <input type="submit" class="profile-edit-btn" value="Edit Profile"/>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="profile-work">
                    <p>POST LINK</p>
                    @forelse($user->posts as $post)
                        <a href="{{ route('post.show', ['post' => $post]) }}">{{ $post->title }}</a><br/>
                    @empty
                        <span>No posts</span>
                    @endforelse
                </div>
            </div>
            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row" id="name-field" @if (Auth::id() == $user->id) profile='' @endif>
                            <div class="col-md-6">
                                <label for="nameInputs">Name</label>
                            </div>
                            <div class="col-md-6">
                                @error('name')
                                    <input type="text" class="is-invalid form-control" name="name" value="{{ old('name') }}" required>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @else
                                    <p>{{ $user->name }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row" id="email-field" @if (Auth::id() == $user->id) profile='' @endif>
                            <div class="col-md-6">
                                <label for="emailInputs">Email</label>
                            </div>
                            <div class="col-md-6">
                                @error('email')
                                    <input type="email" class="is-invalid form-control" name="email" value="{{ old('email') }}" required>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @else
                                    <p>{{ $user->email }}</p>
                                @enderror
                            </div>
                        </div>
                        @if (Auth::id() == $user->id)
                        <div class="row" id="password-field">
                            <div class="col-md-6">
                                <label>Change password</label>
                            </div>
                            <div class="col-md-6">
                                @error('password')
                                    <input type="password" class="is-invalid form-control" name="password" required>
                                    <input type="password" class="is-invalid form-control" name="password_confirmation" required>

                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @else
                                    <p>Click to the field for change password</p>
                                @enderror
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>           
</div>
@endsection