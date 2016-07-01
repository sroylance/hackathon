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

        $product->setWebsiteIds(array(1));
        $product->setCategoryIds(array(31));
        $product->setStockData(array(
            'use_config_manage_stock' => 0, //'Use config settings' checkbox
            'manage_stock' => 1, //manage stock
            'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
            'max_sale_qty' => 2, //Maximum Qty Allowed in Shopping Cart
            'is_in_stock' => 1, //Stock Availability
            'qty' => 100 //qty
            )
        );

        $product->save();

        echo $product->getId();
    }
}

?>