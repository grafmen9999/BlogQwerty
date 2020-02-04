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
     * @var integer $id
     */
    private $id;

    /**
     * @param integer $id
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Фильтрация за тегами
     *
     * @param mixed $query
     *
     * @return Builder
     */
    public function filter($query)
    {
        return $query->whereHas('tags', function ($query) {
            return $query->where('tag_id', '=', $this->id);
        });
    }
}
