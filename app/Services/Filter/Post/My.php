<?php
namespace App\Services\Filter\Post;

use Illuminate\Support\Facades\Auth;

/**
 * Class My
 */
class My implements FilterPost
{
    /**
     * @param mixed $query
     *
     * @return Builder
     */
    public function filter($query)
    {
        return $query->userOwner(Auth::id());
    }
}
