<?php

//admin route
$routes->map('Get', '/'.ADMIN_CUSTOM_URL, 'Admin\CategoryController#index', 'admin.index');

//category routes
$routes->map('Get', '/'.ADMIN_CUSTOM_URL.'/category', 'Admin\CategoryController#index', 'admin.category.index');
$routes->map('Get', '/'.ADMIN_CUSTOM_URL.'/category/create', 'Admin\CategoryController#create', 'admin.category.create');
$routes->map('POST', '/'.ADMIN_CUSTOM_URL.'/category/store', 'Admin\CategoryController#store', 'admin.category.store');
$routes->map('Get', '/'.ADMIN_CUSTOM_URL.'/category/edit/[i:id]', 'Admin\CategoryController#edit', 'admin.category.edit');
$routes->map('POST', '/'.ADMIN_CUSTOM_URL.'/category/update/[i:id]', 'Admin\CategoryController#update', 'admin.category.update');
$routes->map('GET', '/'.ADMIN_CUSTOM_URL.'/category/delete/[i:id]', 'Admin\CategoryController#delete', 'admin.category.delete');

//post routes
$routes->map('Get', '/'.ADMIN_CUSTOM_URL.'/post', 'Admin\PostController#index', 'admin.post.index');
$routes->map('Get', '/'.ADMIN_CUSTOM_URL.'/post/create', 'Admin\PostController#create', 'admin.post.create');
$routes->map('POST', '/'.ADMIN_CUSTOM_URL.'/post/store', 'Admin\PostController#store', 'admin.post.store');
$routes->map('Get', '/'.ADMIN_CUSTOM_URL.'/post/edit/[i:id]', 'Admin\PostController#edit', 'admin.post.edit');
$routes->map('POST', '/'.ADMIN_CUSTOM_URL.'/post/update/[i:id]', 'Admin\PostController#update', 'admin.post.update');
$routes->map('GET', '/'.ADMIN_CUSTOM_URL.'/post/delete/[i:id]', 'Admin\PostController#delete', 'admin.post.delete');


//Auth routes
$routes->map('GET', '/'.ADMIN_CUSTOM_URL.'/signin', 'Admin\AuthController#index', 'admin.auth.signin');
$routes->map('POST', '/'.ADMIN_CUSTOM_URL.'/signin', 'Admin\AuthController#signin', 'admin.auth.dosignin');
$routes->map('GET', '/'.ADMIN_CUSTOM_URL.'/signout', 'Admin\AuthController#signout', 'admin.auth.signout');
