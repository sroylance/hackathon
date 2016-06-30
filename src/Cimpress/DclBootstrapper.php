<?php

namespace Cimpress;

require_once __DIR__.'/../vendor/autoload.php';
require_once 'RefreshToken.php';

class DclBootstrapper {

    const UDS_CLIENT_ID = 'bKcEYMT42Eyg0ynXYqMwfM1jLIlBoHR4';
    const PREPRESS_CLIENT_ID = 'fNsKhNzIaueThLFPX8Luh3s6ru4yqe5R';
    const PREFLIGHT_CLIENT_ID = 'UwGwHs2XtJ0v0ZZmVQlqv8aSndynRZNy';
    const CRISPIFY_CLIENT_ID = 'pl3q5J4khaLTaS7rkv73I87TrTlV7N4I';
    const SURFACESPEC_CLIENT_ID = '6bXolCg7bnB3Xnwg3qMBTBms92eLXv4D';

    private $memcache;


    public function renderDclOptions() {
        $udsAuthToken = self::getAuth0DelegationToken(self::UDS_CLIENT_ID);        
        $prepressAuthToken = self::getAuth0DelegationToken(self::PREPRESS_CLIENT_ID);
        $preflightAuthToken = self::getAuth0DelegationToken(self::PREFLIGHT_CLIENT_ID);        
        $surfaceSpecAuthToken = self::getAuth0DelegationToken(self::SURFACESPEC_CLIENT_ID);    
        $crispifyAuthToken = self::getAuth0DelegationToken(self::CRISPIFY_CLIENT_ID);        
    

$dclOptionsTemplateCode = "var configuration = { 
	services: {
		clients: { 
			upload: {
				form: '#upload-form', // required. a selector for the form that contains a file input
				dropZone: 'body', // only required to allow HTML5 drag and drop from the desktop
				merchantId: 'default' // use your uploads tenant here 
			},
			uds: {
				merchantId: 'internal-test-merchant', // use your UDS merchant ID here
				authToken: " . $udsAuthToken . "
			},
			prepress: {
				authToken: " . $prepressAuthToken . "
			},
			preflight: {
				authToken: " . $preflightAuthToken . "
			},
			surfaceSpecifications: {
				authToken: " . $surfaceSpecAuthToken . "
			},
			crispify: {
					authToken: " . $crispifyAuthToken . "
			} 
		}
	},
	ui: {
		zoomStrategy: {
			initialHeight: .45 // how big each canvas will be initially 
		},
		// each widget you want to use needs to have its enabled flag set to // true and a selector for a container element in which to append the // widget
		widgets: {
			zoom: {
				enabled: true,
				containerElement: '.action-buttons' 
			},
			orientation: { 
				enabled: true,
				containerElement: '.action-buttons' 
			},
			addText: { 
				enabled: true,
				containerElement: '.add-text-container' 
			},
			generatePdf: {
				enabled: true,
				containerElement: '.pdf-button-container' 
			},
			addShape: { 
				enabled: true,
				containerElement: '.add-shapes-container' 
			},
			uploadList: { 
				enabled: true,
				containerElement: '.upload-list-container' 
			},
			uploadButton: { 
				enabled: true,
				containerElement: '.upload-button-container',
				input: '.upload-input' 
			},
			contextualToolbar: {
				enabled: true,
			} 

	},
	localization: { 
		language: 'en',
	} 
};";

print_r($dclOptionsTemplateCode);

return $dclOptionsTemplateCode; 
    }
    
    private static function getAuth0DelegationToken($target_client_id)
    {
        $url = "https://cimpress.auth0.com/delegation?grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer&client_id=QkxOvNz4fWRFT6vcq79ylcIuolFz2cwN&api_type=auth0&scope=openid+name+email+scopes+app_metadata&refresh_token=".REFRESH_TOKEN."&target=".$target_client_id;
        $response = \Httpful\Request::get($url)
            ->expectsJson()
            ->send();
        
        return $response->body->id_token;
    }

}

?>