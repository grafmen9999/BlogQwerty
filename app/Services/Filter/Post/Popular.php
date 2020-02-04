<?php
namespace App\Services\Filter\Post;

/**
 * Class Popular
 */
class Popular implements FilterPostInterface
{
    /**
     * Сортировка за просмотрами (от большего к меньшему)
     *
     * @param mixed $query
     *
     * @return Builder
     */
    public function filter($query)
    {
        return $query->popular();
    }
}
