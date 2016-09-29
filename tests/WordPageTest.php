<?php

use App\Entities\User;

class WordPageTest extends TestCase
{

    public function testLoginRequired()
    {
        $response = $this->call('GET', '/word');
        $this->assertResponseStatus(200);
        $this->assertRedirectedTo('/login');
    }

    public function testIndexAction()
    {
        $user = User::find(1);
        $this->be($user);
        $response = $this->call('GET', '/word');
        $this->assertResponseStatus(200);
        $view = $response->original;
        $this->assertEquals('word.index', $view->name());
    }

}
