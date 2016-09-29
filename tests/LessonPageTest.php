<?php

use App\Entities\User;
use App\Entities\Lesson;

class LessonPageTest extends TestCase
{

    protected function setLoginUser()
    {
        $user = User::find(1);
        $this->be($user);
    }

    public function testLoginRequired()
    {
        $response = $this->call('GET', '/lesson');
        $this->assertResponseStatus(200);
        $this->assertRedirectedTo('/login');
    }

    public function testStoreAction()
    {
        $this->setLoginUser();
        $response = $this->call('POST', '/lesson', [
            'category_id' => 'xxx'
        ]);
        $this->assertResponseStatus(404);
    }

    public function testStoreOkAction()
    {
        $this->setLoginUser();
        $response = $this->call('POST', '/lesson', [
            'category_id' => 1
        ]);
        $this->assertResponseStatus(302);
        $this->assertEquals(true, preg_match('/lesson\/\d+/', $response->getTargetUrl()));
    }

    public function testUpdateFailAction()
    {
        $this->setLoginUser();
        $lesson = Lesson::query()->orderBy('created_at', 'desc')->first();
        $response = $this->call('PUT', '/lesson/' . $lesson->id, [
            'word_id' => 'xxx'
        ]);
        $this->assertResponseStatus(404);
    }

}
