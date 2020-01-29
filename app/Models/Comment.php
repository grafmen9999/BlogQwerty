<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 */
class Comment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['body', 'post_id', 'user_id', 'parent_id'];

    /**
     * @return void
     */
    public function post()
    {
        return $this->belongsTo('\App\Models\Post');
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
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
