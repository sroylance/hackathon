<?php
namespace cimpress\magentoapi;

require_once 'ProductManager.php';

$manager = new \cimpress\magentoapi\ProductManager;

//print_r($manager->getProducts(100));

print_r($manager->createProduct('dummysku2','dummy product 2','this is a dummy product'));
?>