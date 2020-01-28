<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'post_id', 'user_id', 'parent_id'];

    public function post()
    {
        return $this->belongsTo('\App\Models\Post');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
