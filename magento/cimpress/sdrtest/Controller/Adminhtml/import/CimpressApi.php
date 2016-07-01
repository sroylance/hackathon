<?php

namespace Cimpress;
require_once 'httpful.phar';


class PortalApi {

    const MEMCACHED_HOST = '127.0.0.1';
    const MEMCACHED_PORT = 11211;
    const VCS_CLIENT_ID = '4GtkxJhz0U1bdggHMdaySAy05IV4MEDV';
    const SCENE_CLIENT_ID = 'QNDePQ7j8OFB3VqaYkurQBwGLqmlAyqq';
    const VCS_TOKEN_KEY = 'VCS_TOKEN';
    const SCENE_TOKEN_KEY = 'SCENE_TOKEN';

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
            $jwt = $this->getAuth0DelegationToken(self::VCS_CLIENT_ID);
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

    public function getScenes($mcpSku)
    {
        $jwt = $this->memcache->get(self::SCENE_TOKEN_KEY);
        if(empty($jwt))
        {
            $jwt = $this->getAuth0DelegationToken(self::SCENE_CLIENT_ID);
            $this->memcache->set(self::SCENE_TOKEN_KEY, $jwt, 0, 60*60*6);
        }

        $url = 'https://scene.products.cimpress.io/v1/compositeScenesQuery?mcpSku='.$mcpSku;

        $response = \Httpful\Request::get($url)
            ->expectsJson()
            ->addHeader('Authorization', 'Bearer '.$jwt)
            ->addHeader('Accept','application/json')
            ->send();

        $results = $response->body->results;

        $sceneUrls = array();
        foreach($results as $result){
            $detailResponse = \Httpful\Request::get($result->links[0]->href)
            ->expectsJson()
            ->addHeader('Authorization', 'Bearer '.$jwt)
            ->addHeader('Accept','application/json')
            ->send();

            array_push($sceneUrls, 'http://rendering.documents.cimpress.io/v1/preview?width=500&scene='.$detailResponse->body->underlaySceneUri.'&imageuris=http%3A%2F%2Fvistawiki.vistaprint.net%2Fw%2Fimages%2F8%2F86%2F2014_11_16_cimpress_LOGO_TRANSPARENT.png');
        }

        return $sceneUrls;
    }
    
    private function getAuth0DelegationToken($target_client_id)
    {
        $url = "https://cimpress.auth0.com/delegation?grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer&client_id=QkxOvNz4fWRFT6vcq79ylcIuolFz2cwN&api_type=auth0&scope=openid+name+email+scopes+app_metadata&refresh_token=".$this->refresh_token."&target=".$target_client_id;
        $response = \Httpful\Request::get($url)
            ->expectsJson()
            ->send();
        
        return $response->body->id_token;
    }

}

?>