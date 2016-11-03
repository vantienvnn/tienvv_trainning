<?php


class HomeControllerTest extends TestCase
{

    public function testLoginRequired()
    {
        $this->call('GET', '/home');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/login');
    }

    public function testHomePageOk()
    {
        $this->loginAsUser();
        $this->call('GET', '/home');
        $this->assertResponseStatus(200);
        $this->assertViewHas('learnedWords');
        $this->assertViewHas('learned');
        $this->assertViewHas('activities');
        $this->assertViewHas('pageTitle');
        
        $data = $this->response->original->getData();
        $this->assertTrue(is_numeric($data['learnedWords']));
        $this->assertEquals($data['learned'], App\Entities\Activity::ACTION_LEARNED);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $data['activities']);
        foreach ($data['activities'] as $activity) {
            $this->assertInstanceOf(App\Entities\Activity::class, $activity);
        }
        
        $this->assertEquals('home', $this->response->original->name());
    }

}
