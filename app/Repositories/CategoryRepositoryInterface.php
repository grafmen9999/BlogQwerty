<?php
namespace App\Repositories;

interface CategoryRepositoryInterface
{
    public function create(array $data);

    public function all();
}
