<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'language_id',
        'latitude',
        'longitude',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getReview($review_id)
    {
        return $this->reviews()->where('review_id', $review_id)->first();
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'user_languages');
    }

    public function getLanguage($language_id)
    {
        return $this->language()->where('language_id', $language_id)->first();
    }

    public function ussergenres()
    {
        return $this->hasMany(UserGenre::class);
    }
    //aprticipation through event
    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
}
