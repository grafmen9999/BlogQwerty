<?php
namespace App\Repositories;

use \App\Models\Post;
use Illuminate\Support\Collection;

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
     * @param array $filterNames
     * @param integer $userId
     * @param integer $paginate
     *
     * @return Paginator
     */
    public function getByFilter(array $filterNames, $userId, $paginate = 15)
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
     * @return Builder|null
     */
    public function findById($id)
    {
        $post = $this->query->find($id);

        if ($post === null) {
            abort(404);
        }

        return $post;
    }

    public function getComments($id, $paginate = 10)
    {
        $post = $this->findById($id);
        return $post->comments()
            ->where('parent_id', '=', null)
            ->paginate($paginate);
    }

    public function create(array $data)
    {
        $post = new Post($data);
        $post->save();

        return $post;
    }

    public function updateViews($id)
    {
        $post = $this->findById($id);
        
        $post->views = $post->views + 1;
        $post->update(['views']);

        return $post;
    }

    public function update($id, array $data)
    {
        $post = $this->findById($id);

        $post->fill($data);
        $post->update([$data]);

        return $post;
    }

    public function delete($id)
    {
        $post = $this->findById($id);
        $post->delete();
    }

    public function syncTags($id, array $data)
    {
        $post = $this->findById($id);
        $post->tags()->sync($data);
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
            if (!is_array($filterNames->get('filter'))) {
                abort(403);
            }
            
            foreach ($filterNames->get('filter') as $filter) {
                if (!is_null($filter) && app()->has($filter)) {
                    $filters[] = app()->makeWith($filter, ['userId' => $userId]);
                }
            }
        }

        if ($filterNames->has('tags')) {
            if (!is_array($filterNames->get('tags'))) {
                abort(403);
            }
            
            foreach ($filterNames->get('tags') as $tagId) {
                if (!is_null($tagId)) {
                    $filters[] = app()->makeWith('Tag', ['tagId' => $tagId]);
                }
            }
        }

        return $filters;
    }
}
