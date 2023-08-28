<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Organizer extends Model implements Authenticatable
{
    use AuthenticatableTrait, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'city',
        'state',
        'zip_code',
        'bio',
        'image_path',
    ];

    protected $hidden = [
        'password',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
