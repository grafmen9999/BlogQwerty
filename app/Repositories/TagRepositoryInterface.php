<?php
namespace App\Repositories;

interface TagRepositoryInterface
{
    public function create(array $data);

    public function all();

    public function saveToPost($tagId, $postId);
}
