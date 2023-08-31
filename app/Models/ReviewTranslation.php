<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'language_id',
        'comment',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
