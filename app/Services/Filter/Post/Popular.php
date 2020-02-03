<?php
namespace App\Services\Filter\Post;

class Popular implements FilterPost
{
    public function filter($query)
    {
        return $query->popular();
    }
}
