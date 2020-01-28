@extends('layouts.app')

@section('content')
<div class="blog-main">
    <div class="row">
        <div class="col-md-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger" style="text-align: center;" role="alert">
                    @foreach ($errors->all() as $error)
                        <b> {{ $error }}</b><br>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-6 ">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">{{ $post->title }}</h2>
                    @if ($post->tags->count() > 0)
                        <div>Tags:<span class="tags">
                            @foreach($post->tags as $tag)
                                <a class="tag" href="{{ route('post.index', ['tag' => $tag->id]) }} @if(request()->has('filter'))&filter={{ request()->filter }} @endif">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </span></div>
                    @endif
                    <p class="card-text">{!! substr($post->body , 0, 120) !!}</p>
                    <a href="{{ route('post.show', ['post' => $post]) }}" class="btn btn-primary">Read More &rarr;</a>
                </div>
                <div class="card-footer text-muted">
                    <div class="d-flex flex-row justify-content-between">
                        <div><span>Posted on {{ Carbon\Carbon::parse($post->updated_at)->format('d-M-Y') }} by</span>
                            <a href="{{ route('user.show', ['user' => $post->user]) }}">{{ $post->user->name }}</a>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="mx-1"><small>Comments: {{ $post->comments->count() }}</small></div>
                            <div><small>Views: {{ $post->views }}</small></div>
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
    <div>{{ $posts->links() }}</div>
</nav>

@endsection