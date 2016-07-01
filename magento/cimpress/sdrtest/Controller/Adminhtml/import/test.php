<?php

namespace Cimpress;
require 'CimpressApi.php';

$api = new \Cimpress\PortalApi('EepWkCb7gz0vn6rOGW4gldx0PpbBlxdsWIN8RG8WsMtxy');

print_r($api->getScenes('VIP-14039'));
?>