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
}