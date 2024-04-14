<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('actors')->insert([
            ['name' => "Alejandro", 'lastname' => "Campos", 'DoB' => "1980-01-20", 'nacionalidad' => "Ukraine"],
            ['name' => "Sutton", 'lastname' => "Mills", 'DoB' => "2010-10-26", 'nacionalidad' => "Portugal"],
            ['name' => "Alex", 'lastname' => "Wiley", 'DoB' => "1990-11-18", 'nacionalidad' => "Togo"],
            ['name' => "Lauryn", 'lastname' => "Good", 'DoB' => "2013-12-08", 'nacionalidad' => "Kuwait"],
            ['name' => "Davian", 'lastname' => "Wood", 'DoB' => "1992-05-01", 'nacionalidad' => "Guyana"],
            ['name' => "Natalia", 'lastname' => "Randall", 'DoB' => "2003-05-05", 'nacionalidad' => "Armenia"],
            ['name' => "Trenton", 'lastname' => "Beard", 'DoB' => "1991-12-01", 'nacionalidad' => "Dominican Republic"],
            ['name' => "Ezra", 'lastname' => "Bates", 'DoB' => "1989-02-04", 'nacionalidad' => "Spain"],
            ['name' => "Ellis", 'lastname' => "Bell", 'DoB' => "2008-09-12", 'nacionalidad' => "Armenia"],
            ['name' => "Melody", 'lastname' => "Mason", 'DoB' => "1990-08-25", 'nacionalidad' => "North Macedonia"],
        ]);

        DB::table('directors')->insert([
            ['name' => "Alejandro", 'lastname' => "Campos", 'DoB' => "1980-01-20", 'nacionalidad' => "Ukraine"],
            ['name' => "Sutton", 'lastname' => "Mills", 'DoB' => "2010-10-26", 'nacionalidad' => "Portugal"],
            ['name' => "Alex", 'lastname' => "Wiley", 'DoB' => "1990-11-18", 'nacionalidad' => "Togo"],
            ['name' => "Lauryn", 'lastname' => "Good", 'DoB' => "2013-12-08", 'nacionalidad' => "Kuwait"],
            ['name' => "Davian", 'lastname' => "Wood", 'DoB' => "1992-05-01", 'nacionalidad' => "Guyana"],
            ['name' => "Natalia", 'lastname' => "Randall", 'DoB' => "2003-05-05", 'nacionalidad' => "Armenia"],
            ['name' => "Trenton", 'lastname' => "Beard", 'DoB' => "1991-12-01", 'nacionalidad' => "Dominican Republic"],
            ['name' => "Ezra", 'lastname' => "Bates", 'DoB' => "1989-02-04", 'nacionalidad' => "Spain"],
            ['name' => "Ellis", 'lastname' => "Bell", 'DoB' => "2008-09-12", 'nacionalidad' => "Armenia"],
            ['name' => "Melody", 'lastname' => "Mason", 'DoB' => "1990-08-25", 'nacionalidad' => "North Macedonia"],
        ]);

        DB::table('idioms')->insert([
            ['name' => 'Afar ', 'isocode' => 'aa'],
            ['name' => 'Afrikaans ', 'isocode' => 'af'],
            ['name' => 'Akan ', 'isocode' => 'ak'],
            ['name' => 'Albanian ', 'isocode' => 'sq'],
            ['name' => 'Amharic ', 'isocode' => 'am'],
            ['name' => 'Arabic ', 'isocode' => 'ar'],
            ['name' => 'Aragonese ', 'isocode' => 'an'],
            ['name' => 'Armenian ', 'isocode' => 'hy'],
            ['name' => 'Assamese ', 'isocode' => 'as'],
            ['name' => 'Avaric ', 'isocode' => 'av'],
            ['name' => 'Avestan ', 'isocode' => 'ae'],
            ['name' => 'Aymara ', 'isocode' => 'ay'],
            ['name' => 'Azerbaijani ', 'isocode' => 'az'],
            ['name' => 'Bambara ', 'isocode' => 'bm'],
            ['name' => 'Bashkir ', 'isocode' => 'ba'],
            ['name' => 'Basque ', 'isocode' => 'eu'],

        ]);

        DB::table('platforms')->insert([
            ['name' => 'Amazon Prime Video'],
            ['name' => 'Disney'],
            ['name' => 'Apple t v'],
            ['name' => 'Hulu'],
            ['name' => 'Paramount'],
            ['name' => 'Peacock'],
            ['name' => 'Fubo'],
            ['name' => 'Stan'],
            ['name' => 'Acorn TV'],
            ['name' => 'Kanopy'],

        ]);
        $collection = collect()->range(1, 10);

        DB::table('series')->insert([
            [
                'name' => '24 TV series', 'url' => 'https://en.wikiquote.org/wiki/24_(TV_series',
                'platform_id' => $collection->Random(),
                'director_id' => $collection->Random(),
                'idiom_id' => $collection->Random(),
            ],
            [
                'name' => '2 Broke Girls', 'url' => 'https://en.wikiquote.org/wiki/2_Broke_Girls',
                'platform_id' => $collection->Random(),
                'director_id' => $collection->Random(),
                'idiom_id' => $collection->Random(),
            ],
            [
                'name' => '2 Stupid Dogs', 'url' => 'https://en.wikiquote.org/wiki/2_Stupid_Dogs',
                'platform_id' => $collection->Random(),
                'director_id' => $collection->Random(),
                'idiom_id' => $collection->Random(),
            ],
            [
                'name' => '3 South', 'url' => 'https://en.wikiquote.org/wiki/3_South',
                'platform_id' => $collection->Random(),
                'director_id' => $collection->Random(),
                'idiom_id' => $collection->Random(),
            ],
            [
                'name' => '30 Rock', 'url' => 'https://en.wikiquote.org/wiki/30_Rock',
                'platform_id' => $collection->Random(),
                'director_id' => $collection->Random(),
                'idiom_id' => $collection->Random(),
            ],
            [
                'name' => '3-2-1 Penguins!', 'url' => 'https://en.wikiquote.org/wiki/3-2-1_Penguins!',
                'platform_id' => $collection->Random(),
                'director_id' => $collection->Random(),
                'idiom_id' => $collection->Random(),
            ],
            [
                'name' => '3rd Rock from the Sun', 'url' => 'https://en.wikiquote.org/wiki/3rd_Rock_from_the_Sun',
                'platform_id' => $collection->Random(),
                'director_id' => $collection->Random(),
                'idiom_id' => $collection->Random(),
            ],
            [
                'name' => 'The 4400', 'url' => 'https://en.wikiquote.org/wiki/The_4400',
                'platform_id' => $collection->Random(),
                'director_id' => $collection->Random(),
                'idiom_id' => $collection->Random(),
            ],
            [
                'name' => '60 Minutes', 'url' => 'https://en.wikiquote.org/wiki/60_Minutes',
                'platform_id' => $collection->Random(),
                'director_id' => $collection->Random(),
                'idiom_id' => $collection->Random(),
            ],
            [
                'name' => '6teen', 'url' => 'https://en.wikiquote.org/wiki/6teen',
                'platform_id' => $collection->Random(),
                'director_id' => $collection->Random(),
                'idiom_id' => $collection->Random(),
            ],
        ]);

        $collection = collect()->range(1, 10);
        $i = 0;
        while ($i < 10) {
            DB::table('act_sers')->insert([
                'actor_id' => $collection->Random(),
                'serie_id' => $collection->Random(),

            ]);
            $i++;
        }
    }
}
