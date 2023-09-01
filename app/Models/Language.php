<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, ReviewTranslation::class);
    }

    public function events()
    {
        return $this->hasManyThrough(Event::class, EventTranslation::class);
    }

    public function reviewTranslations()
    {
        return $this->hasMany(ReviewTranslation::class);
    }

    public function eventTranslations()
    {
        return $this->hasMany(EventTranslation::class);
    }
}
