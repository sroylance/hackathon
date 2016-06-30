<?php
namespace cimpress\mcp\Controller\Index;

class ProductManager
{
    protected $_objectManager;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager
    ){
        $this->_objectManager = $objectManager;
    }

    public function createProduct($sku, $name, $description)
    {
        $product = $this->_objectManager->create('Magento\Catalog\Model\Product');

        $product->setName($name);
        $product->setSku($sku);
        $product->setAttributeSetId(9);
        $product->setPrice(1);
        $product->setStatus(1);
        $product->setVisibility(4);
        $product->setTypeId('virtual');
        $product->setCustomAttribute('description',$description);
        $product->save();

        echo $product->getId();
    }
}

?>