<?php
namespace App\Repositories;

use App\Models\Tag;

class TagRepositoryEloquent implements TagRepositoryInterface
{
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

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

    public function all()
    {
        return Tag::all();
    }

    public function findById($id)
    {
        $tag = Tag::find($id);

        if ($tag === null) {
            abort(404);
        }

        return $tag;
    }

    public function saveToPost($tagId, $postId)
    {
        $tag = $this->findById($tagId);
        $post = $this->postRepository->findById($postId);
        $tag->posts()->save($post);
    }
}
