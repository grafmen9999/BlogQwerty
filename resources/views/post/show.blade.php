@extends('layouts.app')

@section('content')

<div class="blog-main">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title row">
                        <div class="col-md-12">{{ $post->getAttribute('title') }}</div>
                    </h2>
                    <h4 class="card-title row">
                        <div class="col-md-12 text-muted">{{ $post->getAttribute('category')->name ?? 'Without category' }}</div>
                    </h4>
                    @if ($post->getAttribute('tags')->count() > 0)
                        <div>Tags:<span class="tags">
                            @foreach($post->getAttribute('tags') as $tag)
                                <a class="tag" href="{{ route('post.index', ['tag' => $tag->id]) }} 
                                    @if(request()->has('filter'))
                                        &filter={{ request()->filter }}
                                    @endif"
                                >
                                    {{ $tag->getAttribute('name') }}
                                </a>
                            @endforeach
                        </span></div>
                    @endif
                    <p class="card-text">{!! $post->getAttribute('body') !!}</p>
                </div>
                <div class="card-footer text-muted">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <span>
                                Posted on {{ Carbon\Carbon::parse($post->getAttribute('updated_at'))->format('d-M-Y') }} by
                            </span>
                            <a href="{{ route('user.show', ['user' => $post->user]) }}">
                                {{ $post->getAttribute('user')->getAttribute('name') }}
                            </a>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            @if ($post->getAttribute('user')->getKey() == Auth::id())
                                <a href="{{ route('post.edit', ['post' => $post]) }}" class="btn btn-primary mx-1">Edit</a>
                            @endif
                            <div>Views: {{ $post->getAttribute('views') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.blog-main -->

<div class="input-comments">
    <h3 class="title-comments">Input comments</h3>
    <form action="{{ route('comment.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() ?? '' }}">
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <input type="hidden" name="parent_id" value="{{ $_GET['reply'] ?? '' }}">
        <textarea name="body" class="form-control">@isset($_GET['reply']){{ App\Models\Comment::find($_GET['reply'])->getAttribute('user')->name ?? 'Anonim' }} @endisset</textarea>
        <input type="submit" value="Submit" class="form-control">
    </form>
</div>

<div class="comments">
    <h3 class="title-comments">Комментарии ({{ $post->comments->count() }})</h3>
    <ul class="media-list">
    @include('post.partials.media_comment', ['comments' => $comments])
    </ul>
    <div>{{ $comments->links() }}</div>
</div>

@endsection