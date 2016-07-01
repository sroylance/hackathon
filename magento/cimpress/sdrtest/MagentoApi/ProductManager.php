<?php
namespace cimpress\magentoapi;

require_once 'AuthToken.php';
require_once __DIR__.'/../vendor/autoload.php';

class ProductManager
{
    const GET_PRODUCT_API = "http://localhost/rest/V1/products?searchCriteria[pageSize]=";
    const POST_PRODUCT_API = "http://localhost/rest/V1/products";

    public function __construct(){
    }

    public function getProducts($count)
    {
        $response = \Httpful\Request::get(self::GET_PRODUCT_API.$count)
            ->expectsJson()
            ->addHeader('Authorization', 'Bearer '.MAGENTO_AUTH_TOKEN)
            ->addHeader('Accept','application/json')
            ->send();

        return $response->body;
    }

    public function createProduct($sku, $name, $description)
    {
        $body = array(
            "product"=>array(
                "sku"=> $sku,
                "name" => $name,
                "attribute_set_id" => 9,
                "price" => 1,
                "status" => 1,
                "visibility"=> 4, // catalog and search
                "type_id"=> "virtual",
                "custom_attributes"=> array(
                    array("attribute_code"=>"description", "value"=>$description))
                ),
            "saveOptions"=>true);
        $body = json_encode($body);
        echo $body;

//             {
// "product":{
//     "sku": "10090-White-XL2",
//     "name": "test3",
//     "attribute_set_id": 9,
//     "price": 1,
//     "status": 1,
//     "visibility": 1,
//     "type_id": "virtual",
//     "custom_attributes": [
//         {
//             "attribute_code": "description",
//             "value": "test"
//         }
//     ]
// }, "saveOptions": true }

        $response = \Httpful\Request::post(self::POST_PRODUCT_API)
            ->expectsJson()
            ->sendsJson()
            ->addHeader('Authorization', 'Bearer '.MAGENTO_AUTH_TOKEN)
            ->addHeader('Accept','application/json')
            ->body($body)
            ->send();

        return $response->body;
    }
}

?>