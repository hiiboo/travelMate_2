<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $with = ['translations', 'genres', 'reviews'];

    protected $fillable = [
        'title',
        'description',
        'event_image_path',
        'organizer_id',
        'start_date',
        'end_date',
        'name',
        'address',
        'status',
    ];

    public function isCreatedBy(Organizer $organizer)
    {
        return $this->organizer_id === $organizer->id;
    }
    
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function translations()
    {
        return $this->hasMany(EventTranslation::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'event_genres');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getTranslation($language_id)
    {
        return $this->translations()->where('language_id', $language_id)->first();
    }

    public function getGenre($genre_id)
    {
        return $this->genres()->where('genre_id', $genre_id)->first();
    }

    public function getReview($review_id)
    {
        return $this->reviews()->where('review_id', $review_id)->first();
    }


}
