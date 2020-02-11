<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
        return Carbon::parse($value)->format('d-M-Y h:i:s');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Возвращает теги в этом посте
     *
     * @return BelongsToMany collection tags
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Возвращает комментарии в этом посте
     *
     * @return HasMany collection comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
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
