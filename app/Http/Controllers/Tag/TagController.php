<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Repositories\TagRepositoryInterface;

/**
 * Class TagController
 */
class TagController extends Controller
{
    private $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }
    /**
     * Store a newly created resource in storage.
     * Можем создавать много тегов, в базе они не будут повторяться
     * с одинаковыми именами (а так-же они регистрозависимые)
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $this->tagRepository->create($request->validated());

        return redirect()->back();
    }
}
