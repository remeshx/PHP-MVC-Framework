<?php



$routes->map('Get', '/api', 'HomeController#api', 'api');
$routes->map('POST', '/api-store', 'HomeController#apiStore', 'api.store');
