<?php 

$routes->map('Get', '/', 'HomeController#index', 'home.index');
$routes->map('Get', '/home', 'HomeController#index', 'home.home');
$routes->map('Get', '/category/[i:id]', 'HomeController#category', 'home.category');
$routes->map('Get', '/post/[i:id]', 'HomeController#post', 'home.post');




