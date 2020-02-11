<?php
namespace App\Repositories;

use App\Models\Comment;

class CommentRepositoryEloquent implements CommentRepositoryInterface
{
    public function create(array $data)
    {
        $comment = new Comment($data);
        $comment->save();

        return $comment;
    }
}
