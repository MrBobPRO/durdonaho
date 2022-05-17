<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    use HasFactory;

    // Manuals table is used when users add new author, source, category etc while publishing quote
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
