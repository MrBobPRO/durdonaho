<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function quotes()
    {
        return $this->belongsToMany(Quote::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeUnapproved($query)
    {
        return $query->where('approved', false);
    }

    public static function createUnapprovedCategory($title)
    {
        $category = new Category();
        $category->title = $title;
        $category->save();
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Also delete model relations while deleting
        static::deleting(function ($category) {
            $category->quotes()->detach();
        });
    }
}