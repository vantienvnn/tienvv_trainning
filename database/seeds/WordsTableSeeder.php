<?php

use Illuminate\Database\Seeder;

class WordsTableSeeder extends Seeder
{

    use MasterTableTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = DB::table('categories')->whereIn('id', [1, 2])->get();
        foreach ($categories as $category) {
            factory(App\Entities\Word::class, 50)->create([
                'category_id' => $category->id,
            ])->each(function($word) {
                $correctIndex = mt_rand(0, 3);
                for ($i = 0; $i < 4; $i++) {
                    $word->wordAnswers()->save(factory(App\Entities\WordAnswer::class)->make([
                        'word_id' => $word->id,
                        'correct' => ($i == $correctIndex)
                    ]));
                }
            });
        }
    }

}
