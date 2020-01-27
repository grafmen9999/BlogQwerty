<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //     if (is_null($request)) {
    //         $posts = Post::simplePaginate(15);
    //         Log::log('info', 'Request is null');
    //     } elseif (isset($request->orderBy)) {
    //         if ($request->orderBy == 'my-posts') {
    //             if (Auth::user()) {
    //                 $posts = Auth::user()->posts()->simplePaginate(15);
    //             }
    //         } elseif ($request->orderBy == 'without-comments') {
    //             $posts = Post::all()->transform(function ($item, $key) {
    //                 if ($item->comments()->count != 0) {
    //                     $item->pop();
    //                 }
    //             });
    //             foreach (Post::all() as $post) {
    //                 if ($post->comments()->count() == 0) {
    //                     $posts->push($post);
    //                 }
    //             }

    //             $posts = $posts->simplePaginate(15);
    //         } elseif ($request->orderBy == 'popular') {
    //             $posts = Post::orderBy('views', 'desc')->simplePaginate(15);
    //         }
    //     }

        return view('post.index', [
            'posts' => Post::simplePaginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
