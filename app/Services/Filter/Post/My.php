<?php
namespace App\Services\Filter\Post;

use Illuminate\Support\Facades\Auth;

/**
 * Class My
 */
class My implements FilterPostInterface
{
    private $userId;

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
