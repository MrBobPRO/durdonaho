<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceBook extends Model
{
    use HasFactory;

    public static function createUnapprovedBook($title, $author)
    {
        $book = new SourceBook();
        $book->title = $title;
        $book->author = $author;
        $book->save();
    }
}
