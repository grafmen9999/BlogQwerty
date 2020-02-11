<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 */
class Category extends Model
{
    /**
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * @var array
     */
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
