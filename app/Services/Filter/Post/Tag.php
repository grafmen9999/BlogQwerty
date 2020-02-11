<?php
namespace App\Services\Filter\Post;

/**
 * Class Tag
 */
class Tag implements FilterPostInterface
{
    /**
     * Tag id
     *
     * @var integer $tagId
     */
    private $tagId;

    /**
     * @param integer $tagId
     *
     * @return void
     */
    public function __construct($tagId)
    {
        $this->tagId = $tagId;
    }

    /**
     * Filter by tags
     *
     * @param mixed $query
     *
     * @return Builder
     */
    public function filter($query)
    {
        return $query->whereHas('tags', function ($query) {
            return $query->where('tag_id', '=', $this->tagId);
        });
    }
}
