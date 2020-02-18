<?php
namespace App\Repositories;

use App\Models\Tag;

class TagRepositoryEloquent implements TagRepositoryInterface
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * @param PostRepositoryInterface $postRepository
     *
     * @return void
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Create unique tags
     *
     * @param array $data
     *
     * @return void
     */
    public function create(array $data)
    {
        $tags = preg_split('%[\s,:;|]+%', $data['names']);



        foreach ($tags as $tagName) {
            $tagCount = Tag::where('name', '=', $tagName)->count();

            if ($tagCount == 0) {
                $tags = Tag::create(['name' => $tagName]);
            }

            return null;
        }
    }

    /**
     * Get all tags sort by 'name' fields
     *
     * @return Collection
     */
    public function all()
    {
        return Tag::orderBy('name')->get();
    }

    public function findById($id)
    {
        $tag = Tag::find($id);

        if ($tag === null) {
            abort(404);
        }

        return $tag;
    }

    /**
     * Add belongs between post and tag
     *
     * @param mixed $tagId
     * @param mixed $postId
     *
     * @return void
     */
    public function saveToPost($tagId, $postId)
    {
        $tag = $this->findById($tagId);
        $post = $this->postRepository->findById($postId);
        $tag->posts()->save($post);
    }
}
