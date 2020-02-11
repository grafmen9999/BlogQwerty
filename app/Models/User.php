<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany('\App\Models\Post');
    }

    public function getAvatarSrcAttribute()
    {
        $directory = config('dir_image_avatar', 'image/avatars/');
        $filename = $this->email . '_avatar.jpg';
        $filesystem = new Filesystem();

        if ($filesystem->exists($directory . $filename)) {
            return '/' . $directory . $filename;
        } else {
            $name = explode(' ', $this->name)[0];
            return "https://place-hold.it/64x64?text=$name";
        }
    }
}
