<?php
namespace App\Services\Filter\Post;

/**
 * Class NoAnswer
 */
class NoAnswer implements FilterPost
{
    /**
     * @param mixed $query
     *
     * @return Builder
     */
    public function filter($query)
    {
        return $query->doesntHave('comments');
    }
}
