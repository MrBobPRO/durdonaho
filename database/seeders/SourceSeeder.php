<?php

namespace Database\Seeders;

use App\Models\Source;
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
        $title = ['Из книги "Пятачок"', 'Из фильма "Властелин Колец"', 'Народные мудрости', 'Из аниме'];

        for($i=0; $i<count($title); $i++) {
            $source = new Source();
            $source->title = $title[$i];
            $source->save();
        }
    }
}
