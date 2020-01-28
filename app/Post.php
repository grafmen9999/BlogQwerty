<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
    
    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function scopeUserOwner($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id);
    }
}
