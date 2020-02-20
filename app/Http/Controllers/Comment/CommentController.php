<?php

namespace App\Http\Controllers\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\PostRepositoryInterface;

class CommentController extends Controller
{
    private $postRepository;
    private $commentRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $request->validated();
        
        $comment = $this->commentRepository->create($request->all());
        
        return response()->json(['comments' => $comment], 201);
//        return redirect()->route('post.show', $this->postRepository->findById($request->post_id), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
