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
        $tags = preg_split('%[\s,:;|]+%', $request->names);

        foreach ($tags as $val) {
            $tagCount = Tag::where('name', '=', $val)->count();

            if ($tagCount == 0) {
                Tag::create(['name' => $val]);
            }
        }

        return redirect()->back();
    }
}
