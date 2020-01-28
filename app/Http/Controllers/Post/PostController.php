<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request Сюда передаются фильтры [filter={without-comment, popular, my}, tag={tag_id}]
     * @return \Illuminate\Http\Response view post.index with $post [simplePaginate]
     * Посты мы получаем с условиями фильтраций
     */
    public function index(Request $request)
    {
        $posts = Post::with('comments');

        if ($request->has('filter')) {
            if ($request->filter == ('without-comment')) {
                $posts->doesntHave('comments');
            }

            if ($request->filter == ('popular')) {
                $posts->popular();
            }

            if ($request->filter == ('my') && Auth::user()) {
                $posts->userOwner(Auth::id());
            } else {
                return redirect()->route('post.index')->withErrors(['auth' => 'You\'r not auth']);
            }
        }

        if ($request->has('tag')) {
            $posts->whereHas('tags', function ($query) use ($request) {
                $query->where('tag_id', '=', $request->tag);
            });
        }

        return view('post.index', [
            'posts' => $posts->simplePaginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response view post.create with tags => Tag::all()
     */
    public function create()
    {
        return view('post.create', [
            'tags' => Tag::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response redirect to post.show with result $post
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => 'required|string|max:255',
            "body" => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->except(['user_id']));
        }

        $post = new Post($request->all());

        if ($request->has('tags')) {
            foreach ($request->tags as $tag_id) {
                $tag = Tag::find($tag_id);
                $tag->posts()->save($post);
            }
        }
        
        return redirect()->route('post.show', ['post' => $post]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response view post.show with $post and $post->comments where parent_id = null (paginate)
     */
    public function show(Post $post)
    {
        return view('post.show', [
            'post' => $post,
            'comments' => $post->comments()->where('parent_id', '=', null)->paginate(10) // paginate to 10 comments (parents comment)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response view post.edit with ['post'=>$post, 'tags'=>Tag::all()]
     */
    public function edit(Post $post)
    {
        return view('post.edit', [
            'post' => $post,
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post update model
     * @return \Illuminate\Http\Response redirect to post.show with result $post
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            "title" => 'required|string|max:255',
            "body" => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->except(['user_id']));
        }

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync([]);
        }
        
        $post->update($request->all());

        return redirect()->route('post.show', ['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
    }
}
