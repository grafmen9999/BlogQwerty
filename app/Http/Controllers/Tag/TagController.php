<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

/**
 * Class TagController
 */
class TagController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * Можем создавать много тегов, в базе они не будут повторяться
     * с одинаковыми именами (а так-же они регистрозависимые)
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->tagRepository->create($request->all());

        return redirect()->back();
    }
}
