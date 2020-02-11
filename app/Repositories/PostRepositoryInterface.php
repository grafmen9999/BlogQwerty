<?php
namespace App\Repositories;

/**
 * interface PostRepositoryInterface
 */
interface PostRepositoryInterface
{
    public function getByFilter($filterNames, $userId);

    public function findById($id);
}
