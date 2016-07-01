<?php

namespace cimpress\sdrtest\Plugin\Block\Product\View;

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
        $dataObject = $objectManager->create('Magento\Framework\DataObject');

        $images->addItem($dataObject);

        foreach ($images as $image) {
                /* @var \Magento\Framework\DataObject $image */
                $image->setData(
                    'small_image_url',
                    'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png'
                );
                $image->setData(
                    'medium_image_url',
                    'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png'
                );
                $image->setData(
                    'large_image_url',
                    'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png'
                );
        }

        return $images;
    }
}

?>