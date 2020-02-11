<?php
namespace App\Repositories;

/**
 * TagRepositoryInterface
 */
interface TagRepositoryInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function create(array $data);

    /**
     * @return Collection
     */
    public function all();

    /**
     * @param mixed $tagId
     * @param mixed $postId
     *
     * @return void
     */
    public function saveToPost($tagId, $postId);
}
