<?php
namespace App\Repositories;

interface PostRepository
{
    public function get();

    public function findById($postId);
}
