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

        <!-- the comment box -->

        <div class="well col-md-12">
            <h4><i class="fa fa-paper-plane-o"></i> Leave a Post:</h4>
            @if (count($errors) > 0)
                <div class="alert alert-danger" style="text-align: center;" role="alert">
                @foreach ($errors->all() as $error)
                <b> {{ $error }}</b><br>
                @endforeach
                </div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('post.update', ['post' => $data['post']]) }}" method="POST" role="form">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <input class="form-control my-2" type="text" name="title" value="{{ $data['post']->title }}" placeholder="Title">
                            <textarea class="form-control" rows="3" name="body">{{ $data['post']->getAttribute('body') }}</textarea>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <select name="category_id">
                                        <option value="" selected>-- Category not find --</option>
                                        @foreach($data['categories'] as $category)
                                            <option value="{{ $category->getKey() }}"
                                            @if ($category->getKey() == ($data['post']->getAttribute('category')->id ?? ''))
                                                {{ __('selected') }}
                                            @endif
                                            >
                                                {{ $category->getAttribute('name') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="tags[]" multiple>
                                        @forelse($data['tags'] as $tag)
                                            <option value="{{ $tag->getKey() }}"
@foreach($data['post']->getAttribute('tags') as $postTag)
    @if ($tag->getKey() == $postTag->getKey())
        {{ __('selected') }}
    @endif
@endforeach
                                            >{{ $tag->getAttribute('name') }}
                                            </option>
                                        @empty
                                            <option value="" disabled>-- Tags not find --</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <button type="submit" name="say" value="" class="btn btn-primary"><i class="fa fa-reply"></i>Submit</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <form action="{{ route('tag.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>
                                    <small><strong>Create tags if his don't exists</strong></small>
                                    <input type="text" name="names" class="form-control" placeholder="tag1, tag2, tag3, ...">
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-reply"></i>Create tag</button>
                        </form>
                    </div>
                    <div class="row">
                        <form action="{{ route('category.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>
                                    <small><strong>Create category if his don't exists</strong></small>
                                    <input type="text" name="name" class="form-control" placeholder="Category name">
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-reply"></i>Create category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection