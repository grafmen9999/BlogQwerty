<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class PostController
 */
class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     * view post.index with $post [simplePaginate]
     * Посты мы получаем с условиями фильтраций
     *
     * @param \Illuminate\Http\Request $request Сюда могут передаваться фильтры
     * [filter={without-comment, popular, my}, tag={tag_id}]
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];

        $posts = Post::with('comments');

        /*
        Да, мне стыдно за этот кусочек.
        По хорошему тут надо сделать через интерфейc, и реализовать его,
        возвращать метод будет подготовленный запрос (ИМХО)
        */
        if ($request->has('filter')) {
            try {
                $posts = $this->filters($posts, $request->filter);
            } catch (HttpException $e) {
                return redirect()->route('post.index')->withErrors([
                    'code' => $e->getStatusCode(),
                    'message' => $e->getMessage()
                ]);
            }
        }

        if ($request->has('tag')) {
            $posts->whereHas('tags', function ($query) use ($request) {
                $query->where('tag_id', '=', $request->tag);
            });
        }

        $data['posts'] = $posts->simplePaginate(15);

        return view('post.index', [
            'data' => collect($data)
        ]);
    }

    /**
     * Метод для фильтрации данных
     * @param Post $posts
     * @param string $by
     *
     * @return Post|null
     */
    private function filters($posts, string $by)
    {
        if (strcmp($by, 'without-comment') == 0) {
            return $posts->doesntHave('comments');
        }
        
        if (strcmp($by, 'popular') == 0) {
            return $posts->popular();
        }
        
        if (strcmp($by, 'my') == 0 && Auth::user()) {
            return $posts->userOwner(Auth::id());
        } elseif (strcmp($by, 'my') == 0) {
            // return null;
            throw new HttpException(403, 'You\'re not authorization');
        }

        return $posts;
    }

    /**
     * Show the form for creating a new resource.
     * view post.create with tags => Tag::all()
     * view post.create with categories => Category::all()
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create', [
            'tags' => Tag::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * redirect to post.show with result $post
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
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

        ($post = new Post($request->all()))->save();

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
     * view post.show with $post and $post->comments where parent_id = null (paginate)
     * and add views
     *
     * @param  \App\Models\Post  $post
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $data = [];

        if (request()->has('reply')) {
            $data['replyName'] = ((Comment::find(request()->reply)->getAttribute('user')->name ?? 'Anonim') . ', ');
        }

        $post->setAttribute('views', $post->getAttribute('views') + 1)
            ->update(['views']);

        $data['post'] = $post;
        $data['comments'] = $post->comments()
            ->where('parent_id', '=', null)
            ->paginate(10);

        return view('post.show', [
            'data' => collect($data)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * view post.edit with ['post'=>$post, 'tags'=>Tag::all()]
     *
     * @param  \App\Post  $post
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', [
            'post' => $post,
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * redirect to post.show with result $post
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post update model
     *
     * @return \Illuminate\Http\Response
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
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
    }
}
