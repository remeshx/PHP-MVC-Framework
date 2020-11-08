<?php


/**
 * ------------------
 * return current url
 * ------------------
 */
function currentUrl()
{
    $httpProtocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on") ? "https://" : "http://";
    $currentUrl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    return $httpProtocol.$currentUrl;
}

/**
 * ---------------------
 * return current domain
 * ---------------------
 */
function currentDomain()
{
    $httpProtocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on") ? "https://" : "http://";
    $currentUrl = $_SERVER['HTTP_HOST'];
    return $httpProtocol.$currentUrl;
}

/**
 * ---------------
 * return back url
 * ---------------
 */
function backUrl(){
    return $http_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
}

/**
 * ------------
 * redirect url
 * ------------
 */
function redirect($url)
{
    $url = trim($url, "/ ");
    $url = strpos($url, currentDomain()) === 0 ? $url : currentDomain() . "/" .$url;
    header("Location: ".$url);
    exit();
}


/**
 * -----------------
 * redirect back url
 * -----------------
 */
function back(){
    redirect(backUrl());
}



/**
 * ------------
 * generate url
 * ------------
 */
function generateUrl($url)
{
    return currentDomain()."/".trim($url, '/');
}

/**
 * ------------
 * generate url
 * ------------
 */
function url($url)
{
    return currentDomain()."/".trim($url, '/');
}

/**
 * -------------------------------------
 * return route by name and initial args
 * -------------------------------------
 */
function route($name, $args = [])
{
    global $routes;
    return generateUrl($routes->generate($name, $args));
}

function methodField()
{
    return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
}

