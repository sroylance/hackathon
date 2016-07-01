<?php

namespace Cimpress;


class PortalApi {

    const MEMCACHED_HOST = '127.0.0.1';
    const MEMCACHED_PORT = 11211;
    const VCS_CLIENT_ID = '4GtkxJhz0U1bdggHMdaySAy05IV4MEDV';
    const VCS_TOKEN_KEY = 'VCS_TOKEN';

    private $memcache;

    public function __construct($token){
        $this->memcache = new \Memcache;
        $this->memcache->connect(self::MEMCACHED_HOST, self::MEMCACHED_PORT);
        $this->refresh_token = $token;
    }

    public function getVcsProducts(){
        $jwt = $this->memcache->get(self::VCS_TOKEN_KEY);
        if(empty($jwt))
        {
            $jwt = self::getAuth0DelegationToken(self::VCS_CLIENT_ID);
            $this->memcache->set(self::VCS_TOKEN_KEY, $jwt, 0, 60*60*6);
        }

        $url = 'https://api.cimpress.io/vcs/printapi/v1/partner/products?format=json';

        $response = \Httpful\Request::get($url)
            ->expectsJson()
            ->addHeader('Authorization', 'Bearer '.$jwt)
            ->addHeader('Accept','application/json')
            ->send();

        return $response->body;
    }
    
    private static function getAuth0DelegationToken($target_client_id)
    {
        $url = "https://cimpress.auth0.com/delegation?grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer&client_id=QkxOvNz4fWRFT6vcq79ylcIuolFz2cwN&api_type=auth0&scope=openid+name+email+scopes+app_metadata&refresh_token=".$this->refresh_token."&target=".$target_client_id;
        $response = \Httpful\Request::get($url)
            ->expectsJson()
            ->send();
        
        return $response->body->id_token;
    }

}

?>