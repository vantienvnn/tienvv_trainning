<?php

use App\Repositories\FacebookEloquentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\User;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testAuthorizationUriOk()
    {
        $facebookRepository = app(FacebookEloquentRepository::class);
        $this->call('GET', '/facebook/login');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo($facebookRepository->getAuthorizationUri(['email']));
    }

    public function testConnectWithFacebookRequestFail()
    {
        $this->call('GET', '/facebook/connect');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/login');
    }

    public function testConnectWithNewAccountOk()
    {
        $this->assertEquals(false, User::where('email' , 'dina@gmail.com')->first());
        
        $redirectLoginHelper = Mockery::mock();
        $redirectLoginHelper->shouldReceive('getAccessToken')
            ->withNoArgs()
            ->once()
            ->andReturn('access_token');
        $facebookResponse = Mockery::mock();
        $facebookResponse->shouldReceive('getGraphUser')
            ->withNoArgs()
            ->once()
            ->andReturn([
                'name' => 'Dina',
                'email' => 'dina@gmail.com',
                'id' => 1
            ]);
        $facebookClient = Mockery::mock(new \Facebook\Facebook());
        $facebookClient->shouldReceive('getRedirectLoginHelper')
            ->withNoArgs()
            ->once()
            ->andReturn($redirectLoginHelper);
        $facebookClient->shouldReceive('get')
            ->with('/me?fields=id,name,email', 'access_token')
            ->once()
            ->andReturn($facebookResponse);

        $facebookRepository = $this->mock(FacebookEloquentRepository::class);
        $facebookRepository->setClient($facebookClient);

        $this->call('GET', '/facebook/connect');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/home');
        $user = auth()->user();
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Dina', $user->name);
        $this->assertEquals('dina@gmail.com', $user->email);
    }
    
    public function testConnectExistsAccountOk()
    {
        User::create([
            'name' => 'Dina',
            'email' => 'dina@gmail.com',
            'password' => ''
        ]);
        
        $redirectLoginHelper = Mockery::mock();
        $redirectLoginHelper->shouldReceive('getAccessToken')
            ->withNoArgs()
            ->once()
            ->andReturn('access_token');
        $facebookResponse = Mockery::mock();
        $facebookResponse->shouldReceive('getGraphUser')
            ->withNoArgs()
            ->once()
            ->andReturn([
                'name' => 'Dina',
                'email' => 'dina@gmail.com',
                'id' => 1
            ]);
        $facebookClient = Mockery::mock(new \Facebook\Facebook());
        $facebookClient->shouldReceive('getRedirectLoginHelper')
            ->withNoArgs()
            ->once()
            ->andReturn($redirectLoginHelper);
        $facebookClient->shouldReceive('get')
            ->with('/me?fields=id,name,email', 'access_token')
            ->once()
            ->andReturn($facebookResponse);

        $facebookRepository = $this->mock(FacebookEloquentRepository::class);
        $facebookRepository->setClient($facebookClient);

        $this->call('GET', '/facebook/connect');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/home');
        $user = auth()->user();
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Dina', $user->name);
        $this->assertEquals('dina@gmail.com', $user->email);
    }
    
    
    public function testResponseMissingEmailFail()
    {
        $redirectLoginHelper = Mockery::mock();
        $redirectLoginHelper->shouldReceive('getAccessToken')
            ->withNoArgs()
            ->once()
            ->andReturn('access_token');
        $facebookResponse = Mockery::mock();
        $facebookResponse->shouldReceive('getGraphUser')
            ->withNoArgs()
            ->once()
            ->andReturn([
                'name' => 'Dina',
                'id' => 1
            ]);
        $facebookClient = Mockery::mock(new \Facebook\Facebook());
        $facebookClient->shouldReceive('getRedirectLoginHelper')
            ->withNoArgs()
            ->once()
            ->andReturn($redirectLoginHelper);
        $facebookClient->shouldReceive('get')
            ->with('/me?fields=id,name,email', 'access_token')
            ->once()
            ->andReturn($facebookResponse);

        $facebookRepository = $this->mock(FacebookEloquentRepository::class);
        $facebookRepository->setClient($facebookClient);

        $this->call('GET', '/facebook/connect');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/login');
    }

}
