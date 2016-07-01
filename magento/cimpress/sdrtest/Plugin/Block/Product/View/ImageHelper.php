<?php

namespace cimpress\sdrtest\Plugin\Block\Product\View;

require_once __DIR__.'/../../../../Controller/Adminhtml/import/CimpressApi.php';

use Magento\Framework\App\Config\ScopeConfigInterface; // Needed to retrieve config values
use Cimpress\PortalApi;

class ImageHelper
{
    protected $_product;

    public function beforeInit(\Magento\Catalog\Helper\Image $imageHelper, $product, $imageId, $attributes=[])
    {
        $this->_product = $product;

        return [$product, $imageId, $attributes];
    }

    public function afterGetUrl(\Magento\Catalog\Helper\Image $imageHelper, $url)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $scopeConfig = $objectManager->create('Magento\Framework\App\Config\ScopeConfigInterface');

        $apiClient = new \Cimpress\PortalApi($scopeConfig->getValue('sdrtest/general/refreshtoken'));

        $sku = $this->_product->getSku();
        $scenes = [];
        if(substr( $sku, 3, 1 ) == "-")
        {
            $scenes = $apiClient->getScenes($sku);
        }

        if(count($scenes) > 0){
            return $scenes[0];
        }

        return $url;
    }
}

?>