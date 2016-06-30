<?php
namespace Cimpress;

require_once './CimpressApi.php';

$api = new PortalApi;
print_r($api->getVcsProducts());

?>