@foreach($comments as $comment)
<li class="media">
    @isset($comment->user)
    <div class="media-left">
        <a href=" {{ route('user.show', ['user' => $comment->user]) }} "><img class="media-object img-rounded" src="{{ $comment->user->avatar_src }}" alt="img"></a>
    </div>
    @else
    <div class="media-left"><img class="media-object img-rounded" src="https://place-hold.it/20x20?text=A" alt="img"></div>
    @endisset
    <div class="media-body ml-2">
        <div class="media-heading">
            <div class="author">{{ $comment->user->name ?? 'Anonim' }}</div>
            <div class="metadata"><span class="date">{{ $comment->created_at }}</span></div>
    </div>
    <div class="media-text text-justify">{{ $comment->body }}</div>
    <div class="footer-comment">
        <span class="comment-reply"><a href="?reply={{ $comment->id }}" class="reply">ответить</a></span>
    </div>
    @if ($comment->children->count() > 0)
        <ul class="children">
        @include('post.partials.media_comment', ['comments' => $comment->children])
        </ul>
    @endif
</li>
@endforeach