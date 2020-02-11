<?php
namespace App\Repositories;

/**
 * interface PostRepositoryInterface
 */
interface PostRepositoryInterface
{
    public function getByFilter(array $filterNames, $userId);

    public function findById($id);

    public function updateViews($id);

    public function update($id, array $data);

    public function create(array $data);

    public function delete($id);

    public function getComments($id);

    public function syncTags($id, array $data);
}
