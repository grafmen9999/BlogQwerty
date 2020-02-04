<?php
namespace App\Services\Filter\Post;

/**
 * Class NoAnswer
 */
class NoAnswer implements FilterPostInterface
{
    /**
     * Фильтровать по тему постам, где нет комментариев
     *
     * @param mixed $query
     *
     * @return Builder
     */
    public function filter($query)
    {
        return $query->doesntHave('comments');
    }
}
