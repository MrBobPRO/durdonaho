<?php

namespace Database\Seeders;

use App\Models\Source;
use App\Models\SourceBook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = ['Моя цитата', 'Автор неизвестен', 'Цитата известного автора', 'Цитата из книги', 'Цитата из фильма или сериала', 'Цитата из песни', 'Пословица/поговорка', 'Притча'];
        $key = ['user', 'unknown', 'author', 'book', 'movie', 'song', 'proverb', 'parable'];

        for($i=0; $i<count($title); $i++) {
            $source = new Source();
            $source->title = $title[$i];
            $source->key = $key[$i];
            $source->save();
        }

        $sb = new SourceBook();
        $sb->title = 'Алиса в стране чудес';
        $sb->author = 'Полина Гагарина';
        $sb->save();
    }
}