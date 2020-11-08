<?php

date_default_timezone_set("UTC");
define("CSRF", 1);
define('APPROOT', dirname(dirname(__FILE__)));
define('URLROOT', 'http://localhost/mvc');
define('BASEPATH', '/mvc');

define('DEBUG_LEVEL', E_ALL); // E_NONE & E_ALL
define('DEBUG_SHOW' , true); //Display Errors
define('DEBUG_LOG'  , True); 

define('ADMIN_CUSTOM_URL' , 'myAdmin');