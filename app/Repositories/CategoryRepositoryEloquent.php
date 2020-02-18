<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryRepositoryEloquent implements CategoryRepositoryInterface
{
    public function create(array $data)
    {
        $categories = Category::all();

        $filters = $categories->filter(function ($item) use ($data) {
            return strcmp($item->getAttribute('name'), $data['name']) == 0;
        });

        if ($filters->count() == 0) {
            return Category::create($data);
        }

        return null;
    }

    public function all()
    {
        return Category::all();
    }
}
