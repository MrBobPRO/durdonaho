<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Also delete model relations while deleting
        static::deleting(function ($author) {
            $author->quotes()->each(function ($quote) {
                $quote->delete();
            });

            $author->likes()->each(function ($like) {
                $like->delete();
            });

            $author->favorites()->each(function ($favorite) {
                $favorite->delete();
            });
        });
    }
}