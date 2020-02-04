<?php
namespace App\Repositories;

/**
 * interface PostRepositoryInterface
 */
interface PostRepositoryInterface
{
    public function get();

    public function findById($postId);
}
