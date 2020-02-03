<?php
namespace App\Services\Filter\Post;

class NoAnswer implements FilterPost
{
    public function filter($query)
    {
        return $query->doesntHave('comments');
    }
}
