<?php
namespace App\Services\Filter\Post;

use Illuminate\Support\Facades\Auth;

class My implements FilterPost
{
    public function filter($query)
    {
        return $query->userOwner(Auth::id());
    }
}
