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

    /**
     * @param string $delimiter
     * @param string $text
     *
     * @return false|array
     */
    private function explode(string $delimiter, string $text)
    {
        $strArr = explode($delimiter, $text);

        if ($strArr == false) {
            return false;
        }

        foreach ($strArr as &$str) {
            if (($str = $this->explode($delimiter, $str)) == false) {
                $str = trim($str);
            }
        }

        return $strArr;
    }
}
