<?php

/** 
*----------------------------------------------------------------
* load resources and start request life cycle
*----------------------------------------------------------------
*/
//load config files
load("../resource/config/");


require_once "../core/core_helpers/debug_helper.php";
use Core\Debug\Debug;
new Debug();

//load provider
require_once "../core/request_life/request_life_cycle_start.php";
//load language files
load("../resource/language/fa/");

/**
*----------------------------------------------------------------
* load core_helpers and app_helpers files
*----------------------------------------------------------------
*/
//core helpers
load("../core/core_helpers/");
//app helpers
load("../app/helpers/");

/**
*----------------------------------------------------------------
* do routing
*----------------------------------------------------------------
*/
global $routes;
$routes = new \Core\Router\AdvancedAltoRouter();
$router = new \Core\Router\Routing();
$router->execute();

/** 
*----------------------------------------------------------------
* end of request life cycle
*----------------------------------------------------------------
*/
require_once "../core/request_life/request_life_cycle_end.php";
