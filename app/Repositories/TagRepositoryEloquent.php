<?php
namespace App\Repositories;

use App\Models\Tag;

class TagRepositoryEloquent implements TagRepositoryInterface
{
    public function create(array $data)
    {
        $tags = preg_split('%[\s,:;|]+%', $data['names']);

        foreach ($tags as $tagName) {
            $tagCount = Tag::where('name', '=', $tagName)->count();

            if ($tagCount == 0) {
                Tag::create(['name' => $tagName]);
            }
        }
    }
}
