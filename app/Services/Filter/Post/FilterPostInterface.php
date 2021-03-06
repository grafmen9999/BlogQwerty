<?php
namespace App\Services\Filter\Post;

/**
 * interface FilterPostInterface
 */
interface FilterPostInterface
{
    /**
     * Данная функция будет подготавливать запрос, который в последствии будет возвращать нужную выборку
     *
     * @param mixed $query
     *
     * @return Builder
     */
    public function filter($query);
}
