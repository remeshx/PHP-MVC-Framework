<?php

/** 
*----------------------------------------------------------------------------------------------
* set session options
*----------------------------------------------------------------------------------------------
*/

if(SESSION_DOMAIN != false)
{
	ini_set("session.cookie_domain", "." . SESSION_DOMAIN_URL);
}
session_set_cookie_params(3600);
session_start();
if(!isset($_SESSION['initiated']))
{
	session_regenerate_id();
	$_SESSION['initiated'] = true;	
}

/** 
*----------------------------------------------------------------------------------------------
* set flash message session options
*----------------------------------------------------------------------------------------------
*/
if (isset($_SESSION["systemLastFlashMessage"])) 
{
	unset($_SESSION["systemLastFlashMessage"]);
}
if(isset($_SESSION["systemFlashMessage"]))
{
	$_SESSION["systemLastFlashMessage"] = $_SESSION["systemFlashMessage"];
	unset($_SESSION["systemFlashMessage"]);
}

/** 
*----------------------------------------------------------------------------------------------
* set error message session options
*----------------------------------------------------------------------------------------------
*/
if (isset($_SESSION["systemLastErrorMessage"])) 
{
	unset($_SESSION["systemLastErrorMessage"]);
}
if(isset($_SESSION["systemErrorMessage"]))
{
	$_SESSION["systemLastErrorMessage"] = $_SESSION["systemErrorMessage"];
	unset($_SESSION["systemErrorMessage"]);
}

/** 
*----------------------------------------------------------------------------------------------
* set GET and POST values session options
*----------------------------------------------------------------------------------------------
*/
if(isset($_SESSION["systemRequestParams"]))
{
	$_SESSION["systemOldRequestParams"] = $_SESSION["systemRequestParams"];
	unset($_SESSION["systemRequestParams"]);
}
$requestParams = [];
!isset($_GET) ? : $requestParams = array_merge($requestParams, $_GET);
!isset($_POST) ? : $requestParams = array_merge($requestParams, $_POST);
$_SESSION["systemRequestParams"] = $requestParams;
unset($requestParams);

/** 
*----------------------------------------------------------------------------------------------
* set csrf options
*----------------------------------------------------------------------------------------------
*/
if(CSRF == 1)
{		
	if(!isset($_SESSION['token']) || $_SESSION['token-expire'] < time())
	{	
		$length = 32;
		$_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
		$_SESSION['token-expire'] = time() + 3600;
	}
}else{
	if(isset($_SESSION['token']))
	{
		unset($_SESSION['token']);
		unset($_SESSION['token-expire']);
	}
}