<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Mass assigned
    protected $fillable = [
        'title', 'body', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('\App\Tag');
    }

    public function comments()
    {
        return $this->hasMany('\App\Comment');
    }
}
