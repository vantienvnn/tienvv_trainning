<?php

class WordControllerTest extends TestCase
{

    public function testLoginRequired()
    {
        $this->call('GET', '/word');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/login');
    }

    public function testListWordsOk()
    {
        $this->loginAsUser();
        $this->call('GET', '/word');
        $this->assertResponseStatus(200);
        $this->assertViewHas('pageTitle');
        $this->assertViewHas('words');
        $this->assertViewHas('categories');

        $data = $this->response->original->getData();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $data['words']);
        foreach ($data['words'] as $word) {
            $this->assertInstanceOf(App\Entities\Word::class, $word);
        }
        $this->assertTrue(is_array($data['categories']));
        $this->assertEquals('word.index', $this->response->original->name());
    }

}
