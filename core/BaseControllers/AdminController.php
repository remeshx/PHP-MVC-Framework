<?php

namespace Core\BaseControllers;

use \Core\Auth\Authentication;
use \Core\BaseControllers\Permission;
use \Core\User\userInfo;
use \Core\BaseControllers\BaseController;

class AdminController extends BaseController
{

	// Lets us load model from controllers
	public $isLoggedIn = false;
	public $currentRouteName = null;
	public $checkPermission = 0;
	public function __Construct()
	{
	  global $currentRouteName;
	  //$this->currentRouteName = $currentRouteName;
	  $this->getEnviroment();
	  $this->auth = new Authentication(AUTH_ADMIN);
	  $this->currentUser = false;
	  //dd($currentRouteName);
  
	  $auth = $this->auth->isAuthorize();
	  if ($auth) {
		$this->currentUser = new userInfo($auth);
		$this->isLoggedIn = true;
		if ($this->currentUser->accessAllRoutes <> 1) {
		  $this->checkPermission = Permission::checkPermission($currentRouteName, $this->currentUser);
		  if (!$this->checkPermission OR $this->checkPermission == 0) {
			die('Access Denied!');
		  }
		}
	  } else if (get_class($this) != 'App\Controller\Admin\AuthController') redirect(BASEPATH . '/'. ADMIN_CUSTOM_URL . '/signin');
	}

	public function index()
	{
		return view("admin/index");
	}


}