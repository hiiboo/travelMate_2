<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_genres');
    }

    // get events genres where event_id = $this->id

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_genres');
    }
}
