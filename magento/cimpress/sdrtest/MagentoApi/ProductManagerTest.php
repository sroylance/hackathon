<?php
namespace cimpress\magentoapi;

require_once 'ProductManager.php';

$manager = new \cimpress\magentoapi\ProductManager;

//print_r($manager->getProducts(100));

print_r($manager->createProduct('dummysku','dummy product','this is a dummy product'));
?>