<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Mass assigned
    protected $fillable = [
        'title', 'body', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    public function tags()
    {
        return $this->belongsToMany('\App\Models\Tag');
    }

    public function comments()
    {
        return $this->hasMany('\App\Models\Comment');
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
