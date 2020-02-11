<?php
namespace App\Services\Filter\Post;

/**
 * Class My
 */
class My implements FilterPostInterface
{
    /**
     * @var integer
     */
    private $userId;

    /**
     * @param mixed $userId
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }
    /**
     * @param mixed $query
     *
     * @return Builder
     */
    public function filter($query)
    {
        return $query->userOwner($this->userId);
    }
}
