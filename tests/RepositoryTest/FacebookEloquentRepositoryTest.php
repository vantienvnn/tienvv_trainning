<?php

use App\Entities\User;
use App\Repositories\FacebookEloquentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FacebookEloquentRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    public function testAuthorizationUriOk()
    {
        $facebookRepository = app(FacebookEloquentRepository::class);
        $uri = $facebookRepository->getAuthorizationUri(['email']);
        $this->assertRegExp('/https:\/\/www\.facebook\.com/', $uri);
        $this->assertRegExp('/email/', $uri);
    }

    /**
     * @expectedException ErrorException
     */
    public function testAuthorizationUriFail()
    {
        $facebookRepository = app(FacebookEloquentRepository::class);
        $facebookRepository->getAuthorizationUri();
    }

    public function testConnectToFacebookOk()
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

        $facebookRepository = app(FacebookEloquentRepository::class);
        $facebookRepository->setClient($facebookClient);
        $user = $facebookRepository->connect();
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Dina', $user->name);
        $this->assertEquals('dina@gmail.com', $user->email);
    }
    
    /**
     * @expectedException App\Exceptions\BadRequestHttpException
     */
    public function testConnectToFacebookWithoutRequestFail()
    {
        $facebookRepository = app(FacebookEloquentRepository::class);
        $facebookRepository->connect();
    }
    
    /**
     * @expectedException Facebook\Exceptions\FacebookSDKException
     */
    public function testConnectToFacebookWithoutConfigFail()
    {
        putenv('FACEBOOK_APP_ID=null');
        putenv('FACEBOOK_APP_SECRET=null');
        $facebookRepository = app(FacebookEloquentRepository::class);
        $facebookRepository->connect();
    }

}
