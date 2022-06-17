<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    const OWN_QUOTE_KEY = 'user';
    const UNKNOWN_AUTHOR_KEY = 'unknown';
    const AUTHORS_QUOTE_KEY = 'author';
    const FROM_BOOK_KEY = 'book';
    const FROM_MOVIE_KEY = 'movie';
    const FROM_SONG_KEY = 'song';
    const FROM_PROVERB_KEY = 'proverb';
    const FROM_PARABLE_KEY = 'parable';

    const UNKNOWN_AUTHOR_DEFAULT_IMAGE = '__default-unknown-author.jpg';
    const FROM_BOOK_DEFAULT_IMAGE = '__default-book.jpg';
    const FROM_MOVIE_DEFAULT_IMAEG = '__default-movie.jpg';
    const FROM_SONG_DEFAULT_IMAGE = '__default-image.jpg';
    const FROM_PROVERB_DEFAULT_IMAGE = '__default-proverb.jpg';
    const FROM_PARABLE_DEFAULT_IMAGE = '__default-parable.jpg';

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Also delete model relations while deleting
        static::deleting(function ($source) {
            // remove sources all quotes source_id and create new manual sources for unapproved quotes before source delete
            $source->quotes()->each(function ($quote) use ($source) {
                $quote->source_id = null;
                $quote->save();

                if(!$quote->approved) {
                    $manual = new Manual();
                    $manual->quote_id = $quote->id;
                    $manual->key = 'source';
                    $manual->value = $source->title;
                    $manual->save();
                }
            });
        });
    }
}
