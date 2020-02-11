<?php
namespace App\Repositories;

interface CommentRepositoryInterface
{
    public function create(array $data);

    public function findById($id);
}
