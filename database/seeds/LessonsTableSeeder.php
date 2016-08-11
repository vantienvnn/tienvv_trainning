<?php

use Illuminate\Database\Seeder;
use \App\Lesson;

class LessonsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->find(1);
        $categories = DB::table('categories')->whereIn('id', [1, 2])->get();
        foreach ($categories as $category) {
            factory(App\Lesson::class)->create([
                'user_id' => $user->id,
                'category_id' => $category->id
            ])->each(function($lesson) use ($user, $category) {
                $words = DB::table('words')
                    ->where('category_id', $category->id)
                    ->limit(Lesson::getTotalQuestions())
                    ->get();
                foreach ($words as $word) {
                    $answers = DB::table('word_answers')
                        ->where('word_id', $word->id)->lists('id', 'id');
                    $answers = array_values($answers);
                    DB::table('lesson_words')->insert([
                        'lesson_id' => $lesson->id,
                        'word_id' => $word->id,
                        'word_answer_id' => $answers[mt_rand(0, 3)]
                    ]);
                }
                DB::table('activities')->insert([
                    'target_id' => $lesson->id,
                    'user_id' => $user->id,
                    'action_type' => 'learned'
                ]);
            });
        }
    }

}
