<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

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
            // create new manual sources for unapproved quotes before author delete
            $source->quotes()->unapproved()->each(function ($quote) use ($source) {
                $quote->source_id = 0;
                $quote->save();

                $manual = new Manual();
                $manual->quote_id = $quote->id;
                $manual->key = 'source';
                $manual->value = $source->title;
                $manual->save();
            });
        });
    }
}
