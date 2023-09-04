<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'language_id',
        'title',
        'description',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
