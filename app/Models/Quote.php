<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Manuals table is used when users add new author, source, category etc while publishing quote
    public function manuals()
    {
        return $this->hasMany(Manual::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeUnapproved($query)
    {
        return $query->where('approved', false);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Also delete model relations while deleting
        static::deleting(function ($quote) {
            $quote->categories()->detach();

            $quote->manuals()->each(function ($manual) {
                $manual->delete();
            });

            $quote->likes()->each(function ($like) {
                $like->delete();
            });

            $quote->favorites()->each(function ($favorite) {
                $favorite->delete();
            });

            $quote->reports()->each(function ($report) {
                $report->delete();
            });
        });
    }
}
