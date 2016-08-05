<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WordsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            for ($i = 0; $i < 100; $i++) {
                $wordId = DB::table('words')->insertGetId([
                    'content' => $faker->name,
                    'category_id' => $category->id
                ]);
                $correct = mt_rand(0, 3);
                for ($j = 0; $j < 4; $j++) {
                    DB::table('word_answers')->insert([
                        'content' => $faker->name,
                        'word_id' => $wordId,
                        'correct' => $j == $correct
                    ]);
                }
            }
        }
    }

}
