<?php

use Core\Environment\Environment;
use \Core\Debug\Debug;
/**
*-----------------------------------------------------------------------
* return last post or get field 
*-----------------------------------------------------------------------
*/
function old($name)
{
	if (isset($_SESSION["systemOldRequestParams"][$name])) {
		return $_SESSION["systemOldRequestParams"][$name];		
	}else{
		return false;
	}
}

/**
*-----------------------------------------------------------------------
* return flash content when message null OR set message in flash content 
*-----------------------------------------------------------------------
*/
function flash($name, $message = null)
{
	if (empty($name)) return false;
	if(empty($message))
	{
		if (!isset($_SESSION["systemLastFlashMessage"]) ) return false;
		if (isset($_SESSION["systemLastFlashMessage"][$name])) {
			$temprary = $_SESSION["systemLastFlashMessage"][$name];
			unset($_SESSION["systemLastFlashMessage"][$name]);
			return $temprary;		
		}else{
			return false;
		}
	}else{
		$_SESSION["systemLastFlashMessage"][$name] = $message;
	}
	
}

/**
*-----------------------------------------------------------------------
* if flash exist return true aand if flash not exist return false
*-----------------------------------------------------------------------
*/
function flashExists($name = null)
{
	if($name === null)
	{
		return (!isset($_SESSION["systemLastFlashMessage"]) || count($_SESSION["systemLastFlashMessage"]) === 0) ? false : count($_SESSION["systemLastFlashMessage"]);
	}
	else
	{
		return isset($_SESSION["systemLastFlashMessage"][$name]) === true ? true : false;
	}
}

/**
*-----------------------------------------------------------------------
* return all flash message values 
*-----------------------------------------------------------------------
*/
function allFlashes()
{
	if (isset($_SESSION["systemLastFlashMessage"])) {
		$temprary = $_SESSION["systemLastFlashMessage"];
		unset($_SESSION["systemLastFlashMessage"]);
		return $temprary;		
	}else{
		return false;
	}	
}

/**
*-----------------------------------------------------------------------
* return error content when message null OR set message in error content 
*-----------------------------------------------------------------------
*/
function error($name, $message = null)
{
	
	if($message === null)
	{
		if (isset($_SESSION["systemLastErrorMessage"][$name])) {
			$temprary = $_SESSION["systemLastErrorMessage"][$name];
			unset($_SESSION["systemLastErrorMessage"][$name]);
			return $temprary;		
		}else{
			return false;
		}
	}else{
		$_SESSION["systemErrorMessage"][$name] = $message;
	}
	
}

/**
*-----------------------------------------------------------------------
* if error exist return true aand if error not exist return false
*-----------------------------------------------------------------------
*/
function errorExist($name = null)
{
	if($name === null)
	{
		return (!isset($_SESSION["systemLastErrorMessage"]) || count($_SESSION["systemLastErrorMessage"]) === 0) ? false : count($_SESSION["systemLastErrorMessage"]);
	}
	else
	{
		return isset($_SESSION["systemLastErrorMessage"][$name]) === true ? true : false;
	}
}

/**
*-----------------------------------------------------------------------
* return all flash message values 
*-----------------------------------------------------------------------
*/
function allErrors()
{
	if (isset($_SESSION["systemLastErrorMessage"])) {
		$temprary = $_SESSION["systemLastErrorMessage"];
		unset($_SESSION["systemLastErrorMessage"]);
		return $temprary;		
	}else{
		return false;
	}	
}


function csrf()
{
	if(CSRF == 1) echo '<input name="token" type="hidden" value="' . $_SESSION['token'] . '" />';
}

function resetCSRF()
{
	$length = 32;
	$_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
	$_SESSION['token-expire'] = time() + 3600;	
}

/**
*-----------------------------------------------------------------------
* Auth Sessions
*-----------------------------------------------------------------------
*/
function createLoginSession($user, $Gkey)
    {
		$userIp = $_SERVER['REMOTE_ADDR'];
		if ($userIp=='::1') $userIp='127.0.0.1';

		$nums = explode('.', $userIp) ;
		$ip = $nums[0]. $nums[1] .$nums[2] ; 

		$userhash = md5(SESSION_KEY.$nums[0].$_SERVER['HTTP_USER_AGENT']. $user->userNam .$nums[1].$user->dateRegistered.$nums[2]);
		$fp = md5($_SERVER['HTTP_USER_AGENT']. SESSION_KEY);

		$_SESSION['bauid'] = $user->id;
		$_SESSION['Gkey'] = $Gkey;
		$_SESSION['karbar'] = md5($user->userNam.$ip. SESSION_KEY);	
		$_SESSION['fingerprint'] = $fp;	
		$_SESSION['userhash'] = $userhash;	
		$_SESSION['time'] = time();
		$_SESSION['access'] = time();
		return true;
	}
	
	function checkUserSessionGKey()
    {
		$fp = md5($_SERVER['HTTP_USER_AGENT']. SESSION_KEY);

		//check session exists
		if ((!isset($_SESSION['Gkey'])) or (!isset($_SESSION['fingerprint'])) or 
		(!isset($_SESSION['karbar'])) or ($_SESSION['fingerprint']!= $fp) or
		(!isset($_SESSION['userhash'])) or (!isset($_SESSION['bauid']))) { 
		return false;
		exit;
		}
		$key= str_replace("%","_",$_SESSION['Gkey']); 
		$key= Environment::cleanItem($key);
		if ($_SESSION['access']+ SESSION_EXP_MIN * 60 < time()) {
		$msg = MSG_SESSION_EXP;
		clearSessions();
		return ($msg);
		} 
		if ($_SESSION['time']+10*60 < $_SESSION['access']) {
		$_SESSION['time'] = time();
		}
		return $_SESSION['Gkey'];
	}
	

	function checkUserKeyIsValid($user) 
    {
		$userIp = $_SERVER['REMOTE_ADDR'];
		if ($userIp=='::1') $userIp='127.0.0.1';

		$nums = explode('.', $userIp) ;
		$ip = $nums[0]. $nums[1] .$nums[2] ;
		$userhash = md5(SESSION_KEY.$nums[0].$_SERVER['HTTP_USER_AGENT'].$user->userNam .$nums[1].$user->dateRegistered.$nums[2]);
		if ($_SESSION['userhash']==$userhash) 
		{
		if (md5($user->userNam.$ip.SESSION_KEY) == $_SESSION['karbar']) return true;   
		else return false;   
		} else return false;   
	}
	

	function clearSessions() 
    {
		UNSET($_SESSION['userhash']);
		UNSET($_SESSION['bauid']);
		UNSET($_SESSION['Gkey']);
		UNSET($_SESSION['karbar']);
		UNSET($_SESSION['fingerprint']);
		UNSET($_SESSION['access']);
		UNSET($_SESSION['time']);		  
		SESSION_DESTROY();
    }