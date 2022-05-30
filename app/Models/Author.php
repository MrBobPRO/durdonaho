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
            $author->quotes()->approved()->each(function ($quote) {
                $quote->delete();
            });

            $author->likes()->each(function ($like) {
                $like->delete();
            });

            $author->favorites()->each(function ($favorite) {
                $favorite->delete();
            });

            // create new manual authors for unapproved quotes before author delete
            $author->quotes()->unapproved()->each(function ($quote) use ($author) {
                $quote->author_id = 0;
                $quote->save();

                $manual = new Manual();
                $manual->quote_id = $quote->id;
                $manual->key = 'author';
                $manual->value = $author->name;
                $manual->save();
            });
        });
    }
}