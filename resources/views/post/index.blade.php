@extends('layouts.app')

@section('content')
<div class="blog-main">
    <div class="row">
        <div class="col-md-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger" style="text-align: center;" role="alert">
                    @foreach ($errors->all() as $error)
                        <b>{{ $error }}</b><br>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        @forelse($data->get('posts') as $post)
        <div class="col-md-6 ">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title row">
                        <div class="col-md-12">{{ $post->getAttribute('title') }}</div>
                    </h2>
                    <h4 class="card-title row">
                        <div class="col-md-12 text-muted">{{ $post->getAttribute('category')->name ?? 'Without category' }}</div>
                    </h4>
                    @if ($post->getAttribute('tags')->count() > 0)
                        <div>Tags:
                                <span class="tags">
                                @foreach($post->getAttribute('tags') as $tag)
                                    <a class="tag" href="{{ route('post.index', ['tags[]' => $tag->getKey()]) }}">
                                        {{ $tag->getAttribute('name') }}
                                    </a>
                                @endforeach
                            </span>
                        </div>
                    @endif
                    <p class="card-text">{{ substr(strip_tags($post->getAttribute('body')) , 0, 120) }} <i><b>[read more]</b></i></p>
                    <a href="{{ route('post.show', ['post' => $post]) }}" class="btn btn-primary">Read More &rarr;</a>
                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-7">
                            <span>
                                Posted on {{ $post->getAttribute('created_at') }} by
                            </span>
                            <a href="{{ route('user.show', ['user' => $post->getAttribute('user')]) }}">
                                {{ $post->getAttribute('user')->getAttribute('name') }}
                            </a>
                        </div>
                        <div class="col-md-5 d-flex flex-row justify-content-between">
                            <div class="mx-1"><small>Comments: {{ $post->getAttribute('comments')->count() }}</small></div>
                            <div><small>Views: {{ $post->getAttribute('views') }}</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="col-md-12">
                <div class="card">
                    <div class="card-title text-muted d-flex justify-content-center">
                        Blog post not find
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div><!-- /.blog-main -->

<nav class="blog-pagination">
    <div>{{ $data->get('posts')->links() }}</div>
</nav>

@endsection