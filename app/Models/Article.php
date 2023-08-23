<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'status', 'image_path'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'article_genres');
    }

    public function translations()
    {
        return $this->hasMany(ArticleTranslation::class);
    }

    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }
}
