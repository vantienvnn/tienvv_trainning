<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Exceptions\BadRequestHttpException;
use App\Entities\User;

@session_start();

/**
 * Interface HomeRepository
 * @package namespace App\Repositories;
 */
class FacebookEloquentRepository extends BaseRepository implements FacebookRepository
{

    protected $client;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function getAuthorizationUri(array $scopes)
    {
        $helper = $this->getClient()->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl(url('/facebook/connect'), $scopes);
        return $loginUrl;
    }

    public function connect()
    {   
        $helper = $this->getClient()->getRedirectLoginHelper();
        $accessToken = $helper->getAccessToken();
        
        if (empty($accessToken)){
            throw new BadRequestHttpException('Invaild access token');
        }
        
        $response = $this->getClient()->get('/me?fields=id,name,email', $accessToken);
        $data = $response->getGraphUser();
        
        if (empty($data['email'])) {
            throw new BadRequestHttpException('Please approve permission to get your email');
        }
        
        $user = $this->makeModel()->where('email', $data['email'])->first();
        if (!empty($user)) {
            return $user;
        }
        return $this->create([
            'name' => $data['name'],
            'facebook_id' => $data['id'],
            'email' => $data['email'],
            'password' => ''
        ]);
    }

    public function getClient()
    {
        if (empty($this->client)) {
            $this->client = new \Facebook\Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_APP_SECRET'),
            ]);
        }
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

}
