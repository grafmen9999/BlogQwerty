<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 */
class CategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = Category::all();

        $filters = $categories->filter(function ($item, $key) use ($request) {
            return strcmp($item->getAttribute('name'), $request->name) == 0;
        });

        if ($filters->count() == 0) {
            Category::create($request->all());
        }

        return redirect()->back();
    }
}
