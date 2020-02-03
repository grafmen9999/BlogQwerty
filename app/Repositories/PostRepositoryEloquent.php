<?php
namespace App\Repositories;

use \App\Models\Post;

class PostRepositoryEloquent implements PostRepository
{
    private $query;

    public function __construct()
    {
        $this->query = Post::with('comments');
    }

    public function get(array $filters = [], $paginate = 15)
    {
        foreach ($filters as $filter) {
            $this->query = $filter->filter($this->query);
        }

        return $this->query->simplePaginate($paginate);
    }

    public function findById($postId)
    {
        return $this->query->find($postId);
    }
}
