<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Post
 */
class Post extends Model
{
    
    /**
     * @var array
     */
    protected $fillable = ['title', 'body', 'user_id', 'category_id'];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-M-Y h:i:s');
    }

    /**
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    /**
     * @return void
     */
    public function category()
    {
        return $this->belongsTo('\App\Models\Category');
    }

    /**
     * Возвращает теги в этом посте
     *
     * @return \App\Models\Tag collection tags
     */
    public function tags()
    {
        return $this->belongsToMany('\App\Models\Tag');
    }

    /**
     * Возвращает комментарии в этом посте
     *
     * @return \App\Models\Comment collection comments
     */
    public function comments()
    {
        return $this->hasMany('\App\Models\Comment');
    }

    /**
     * Возвращает все посты отсортированные за просмотрами
     *
     * @return mixed
     */
    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    /**
     * Получаем все посты которыми владеет выбранный юзер
     *
     * @param mixed $query
     * @param mixed $user_id
     *
     * @return mixed
     */
    public function scopeUserOwner($query, $userId)
    {
        return $query->where('user_id', '=', $userId);
    }
}
