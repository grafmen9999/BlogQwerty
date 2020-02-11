<?php
namespace App\Repositories;

use \App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PostRepositoryEloquent
 *
 * Реализация интерфейса репозитория для включения логики получения постов в этот класс
 */
class PostRepositoryEloquent implements PostRepositoryInterface
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
     * @param integer $userId
     * @param integer $paginate
     *
     * @return Paginator
     */
    public function getByFilter($filterNames, $userId, $paginate = 15)
    {
        $filters = $this->filters(collect($filterNames), $userId);

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
    public function findById($id)
    {
        return $this->query->find($id);
    }
    
    /**
     * Функция фильтрации. Вынес её в приватную функцию контроллера.
     * Создаю необходимые классы фильтров чтоб можно было в цикле подготовить нужный запрос.
     * Имена фильтров регистрозависимые.
     *
     * P.S. Мне кажется что так будет небезопасно. Наверное стоит будет немного переделать данную фичу.
     *
     * @param Request $request
     *
     * @return array PostFilter
     */
    private function filters(Collection $filterNames, $userId)
    {
        $filters = [];

        if ($filterNames->has('filter')) {
            foreach ($filterNames->get('filter') as $filter) {
                if (!is_null($filter) && app()->has($filter)) {
                    $filters[] = app()->makeWith($filter, ['userId' => $userId]);
                }
            }
        }

        if ($filterNames->has('tags')) {
            foreach ($filterNames->get('tags') as $tagId) {
                if (!is_null($tagId)) {
                    $filters[] = app()->makeWith('Tag', ['tagId' => $tagId]);
                }
            }
        }

        return $filters;
    }

}
