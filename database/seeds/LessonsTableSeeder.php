<?php

use Illuminate\Database\Seeder;

class LessonsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = DB::table('categories')->get();
        $user = DB::table('users')->where('email', 'demo@gmail.com')->first();
        foreach ($categories as $category) {
            for ($i = 0; $i < mt_rand(1, 3); $i++) {
                $words = DB::table('words')
                ->where('category_id', $category->id)
                ->orderBy('id', 'asc')
                ->limit(20)
                ->skip($i * 20)
                ->get();
                $lessonId = DB::table('lessons')->insertGetId([
                    'result' => 1,
                    'category_id' => $category->id,
                    'user_id' => $user->id
                ]);
                foreach ($words as $word) {
                    $answers = DB::table('word_answers')
                    ->where('word_id', $word->id)->lists('id', 'id');
                    $answers = array_values($answers);
                    DB::table('lesson_words')->insert([
                        'lesson_id' => $lessonId,
                        'word_id' => $word->id,
                        'word_answer_id' => $answers[mt_rand(0, 3)]
                    ]);
                }
                DB::table('activities')->insert([
                    'target_id' => $lessonId,
                    'user_id' => $user->id,
                    'action_type' => 'learned'
                ]);
            }
        }
    }

}
