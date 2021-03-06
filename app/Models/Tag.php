<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 */
class Tag extends Model
{
    /**
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return mixed
     */
    public function posts()
    {
        return $this->belongsToMany('\App\Models\Post');
    }
}
