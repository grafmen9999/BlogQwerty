<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 */
class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param CategoryRepositoryInterface $categoryRepository
     *
     * @return void
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->categoryRepository->create($request->all());

        return redirect()->back();
    }
}
