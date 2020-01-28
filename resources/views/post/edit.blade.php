@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: "textarea",
                menu: {
                    table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'}
                },
                plugins: [
                    "advlist autolink lists link image charmap preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            });
        </script>
        <hr>

        <!-- the comment box -->

        <div class="well">
            <h4><i class="fa fa-paper-plane-o"></i> Leave a Post:</h4>
            @if (count($errors) > 0)
                <div class="alert alert-danger" style="text-align: center;" role="alert">
                @foreach ($errors->all() as $error)
                <b> {{ $error }}</b><br>
                @endforeach
                </div>
            @endif
            <form action="{{ route('post.update', ['post' => $post]) }}" method="POST" role="form">
                @csrf
                @method('put')
                <div class="form-group">
                    <input class="form-control my-2" type="text" name="title" value="{{ $post->title }}" placeholder="Title">
                    <textarea class="form-control" rows="3" name="body">{{ $post->body }}</textarea>
                    <select class="form-control" name="tags[]" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}"
                            @foreach($post->tags as $post_tag) @if ($tag->id == $post_tag->id) selected @endif @endforeach
                            >{{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <button type="submit" name="say" value="" class="btn btn-primary"><i class="fa fa-reply"></i>Submit</button>
            </form>
        </div>

        <hr>   
    </div>
</div>

@endsection