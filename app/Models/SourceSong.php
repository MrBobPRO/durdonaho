<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceSong extends Model
{
    use HasFactory;

    public static function createUnapprovedSong($title, $singer)
    {
        $song = new SourceSong();
        $song->title = $title;
        $song->singer = $singer;
        $song->save();
    }
}