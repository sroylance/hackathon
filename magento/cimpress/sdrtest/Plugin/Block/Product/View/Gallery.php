<?php

namespace cimpress\sdrtest\Plugin\Block\Product\View;

require_once __DIR__.'/../../../../Controller/Adminhtml/import/CimpressApi.php';

use Magento\Framework\App\Config\ScopeConfigInterface; // Needed to retrieve config values
use Cimpress\PortalApi;

/**
 * Plugin for \Magento\Catalog\Block\Product\View\Gallery
 */
class Gallery
{
    /**
     * Retrieve media gallery images
     *
     * @return \Magento\Framework\Data\Collection
     */
    public function afterGetGalleryImages(\Magento\Catalog\Block\Product\View\Gallery $gallery, $images)
    {
        $p = $gallery->getProduct();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $scopeConfig = $objectManager->create('Magento\Framework\App\Config\ScopeConfigInterface');

        $apiClient = new \Cimpress\PortalApi($scopeConfig->getValue('sdrtest/general/refreshtoken'));

        foreach($apiClient->getScenes($p->getSku()) as $scene){
            $dataObject = $objectManager->create('Magento\Framework\DataObject');

            $images->addItem($dataObject);

            $dataObject->setData(
                    'small_image_url',
                    $scene
                );
            $dataObject->setData(
                'medium_image_url',
                $scene
            );
            $dataObject->setData(
                'large_image_url',
                $scene
            );
        }

        return $images;
    }
}

?>