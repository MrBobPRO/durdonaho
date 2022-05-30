<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    use HasFactory;

    // Manuals table is used when users add new author, source or category while publishing quote
    // $manuals may be one of items in array : ['author', 'source', 'categories'];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}