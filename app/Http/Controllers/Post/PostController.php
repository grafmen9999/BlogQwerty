<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;

/**
 * Class PostController
 */
class PostController extends Controller
{
    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;
    protected $tagRepository;
    protected $categoryRepository;
    protected $commentRepository;

    /**
     * @param PostRepositoryInterface $repository
     *
     * @return void
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        CommentRepositoryInterface $commentRepository,
        TagRepositoryInterface $tagRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     * view post.index with $post [simplePaginate]
     * Посты мы получаем с условиями фильтраций
     *
     * @param \Illuminate\Http\Request $request Сюда могут передаваться фильтры
     * [filter[]={NoAnswer, Popular, My}, tags[]={tagId}]
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        Log::log('info', ($request->all()));
        
        $data = [];

        $data['posts'] = $this->postRepository->getByFilter($request->all(), Auth::id());

        return response()->json(['data' => $data], 200);

        // return view('post.index', [
        //     'data' => collect($data)
        // ]);
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
        $data = [];

        $data['tags'] = $this->tagRepository->all();
        $data['categories'] = $this->categoryRepository->all();

        return view('post.create', [
            'data' => $data
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
    public function store(PostRequest $request)
    {
        $request->validated();

        $post = $this->postRepository->create($request->all());

        if ($request->has('tags')) {
            foreach ($request->tags as $tagId) {
                $this->tagRepository->saveToPost($tagId, $post->id);
            }
        }
        
        return response()->json(['post' => $post], 201);
//         return redirect()->route('post.show', ['post' => $post], 201);
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
    public function show($id)
    {
        $post = $this->postRepository->findById($id);
        $data = [];

        if (request()->has('reply')) {
            $data['replyName'] = (
                $this->commentRepository
                    ->findById(request()->reply)
                    ->user->name ?? 'Anonim') . ', ';
        }

        $this->postRepository->updateViews($id);

        $data['post'] = $post;
        $data['comments'] = $this->postRepository->getComments($id);

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
    public function edit($id)
    {
        $data = [];

        $data['post'] = $this->postRepository->findById($id);
        $data['categories'] = $this->categoryRepository->all();
        $data['tags'] = $this->tagRepository->all();

        return view('post.edit', [
            'data' => $data,
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
    public function update(PostRequest $request, $id)
    {
        $request->validated();

        if ($request->has('tags')) {
            $this->postRepository->syncTags($id, $request->tags);
        } else {
            $this->postRepository->syncTags($id, []);
        }
        
        /* @var $post \App\Models\Post */
        $post = $this->postRepository->update($id, $request->all());

        return response()->json(['post' => $post], 200);
        // return response(view(route('post.show', ['post' => $post])), 200);
        // return redirect()->route('post.show', ['post' => $post], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postRepository->delete($id);
    }
}
