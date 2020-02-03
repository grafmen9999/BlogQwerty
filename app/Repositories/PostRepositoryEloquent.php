<?php
namespace App\Repositories;

use \App\Models\Post;

/**
 * Class PostRepositoryEloquent
 *
 * Реализация интерфейса репозитория для включения логики получения постов в этот класс
 */
class PostRepositoryEloquent implements PostRepository
{
    private $query;

    public function __construct()
    {
        $this->query = Post::with('comments');
    }

    /**
     * Получить коллекцию, которая фильтруется по каким-то правилам
     *
     * @param array $filters
     * @param integer $paginate
     *
     * @return Eloquent\Collection\simplePaginate
     */
    public function get(array $filters = [], $paginate = 15)
    {
        foreach ($filters as $filter) {
            $this->query = $filter->filter($this->query);
        }

        return $this->query->simplePaginate($paginate);
    }

    /**
     * Find by id
     *
     * @param mixed $postId
     *
     * @return void
     */
    public function findById($postId)
    {
        return $this->query->find($postId);
    }
}
