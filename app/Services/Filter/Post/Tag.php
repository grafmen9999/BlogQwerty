<?php
namespace App\Services\Filter\Post;

class Tag implements FilterPost
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function filter($query)
    {
        return $query->whereHas('tags', function ($query) {
            return $query->where('tag_id', '=', $this->id);
        });
    }
}
