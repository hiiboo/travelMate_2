<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventGenre extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'genre_id',
    ];  
}
