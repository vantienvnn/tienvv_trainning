<?php

use App\Entities\User;

class HomePageTest extends TestCase
{

    public function testLoginRequired()
    {
        $response = $this->call('GET', '/home');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/login');
    }

    public function testIndexAction()
    {
        $user = User::find(1);
        $this->be($user);
        $response = $this->call('GET', '/home');
        $this->assertResponseStatus(302);
        $view = $response->original;
        $this->assertEquals('home', $view->name());
    }

}
