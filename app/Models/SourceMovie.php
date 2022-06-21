<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceMovie extends Model
{
    use HasFactory;

    public static function createUnapprovedMovie($title, $year)
    {
        $movie = new SourceMovie();
        $movie->title = $title;
        $movie->year = $year;
        $movie->save();
    }
}
