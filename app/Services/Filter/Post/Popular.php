<?php
namespace App\Services\Filter\Post;

/**
 * Class Popular
 */
class Popular implements FilterPost
{
    /**
     * @param mixed $query
     *
     * @return Builder
     */
    public function filter($query)
    {
        return $query->popular();
    }
}
