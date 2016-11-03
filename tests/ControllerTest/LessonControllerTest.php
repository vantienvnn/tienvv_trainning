<?php

use App\Entities\Lesson;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LessonControllerTest extends TestCase
{

    use DatabaseTransactions;

    public function testLoginRequired()
    {
        $this->call('GET', '/lesson');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/login');
    }

    public function testStoreLessonFail()
    {
        $this->loginAsUser();
        $this->call('POST', '/lesson', [
            'category_id' => 'xxx'
        ]);
        $this->assertResponseStatus(404);
    }

    public function testStoreLessonOk()
    {
        $this->loginAsUser();
        $categoryId = 1;
        $lesson = Lesson::where('category_id' , $categoryId)->first();
        $lessonRepository = $this->mock(App\Repositories\LessonRepositoryEloquent::class);
        $lessonRepository->shouldReceive('startLesson')
            ->with($categoryId)
            ->once()
            ->andReturn($lesson);
        $this->call('POST', '/lesson', [
            'category_id' => $categoryId
        ]);
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/lesson/' . $lesson->id);
    }

    public function testUpdateLessonFail()
    {
        $this->loginAsUser();
        $lesson = Lesson::query()->orderBy('created_at', 'desc')->first();
        $this->call('PUT', '/lesson/' . $lesson->id, [
            'word_id' => 'xxx'
        ]);
        $this->assertResponseStatus(404);
    }

}
