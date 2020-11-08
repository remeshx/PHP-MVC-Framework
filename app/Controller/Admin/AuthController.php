<?php

namespace App\Controller\Admin;



use \Core\Debug\Debug;
use \Core\BaseControllers\AdminController;
use \Core\User\userInfo;

use \App\Model\Category;
use \App\Model\Admin\AdminUsers;

class AuthController extends AdminController
{
	public function index()
	{		
		return view("admin/auth/signin");
	}

	public function signin()
	{
		if (!isset($this->env->vars['username']) or ($this->env->vars['username'] == '')) 
		{
			DEBUG::doLog('error login 1: ' . MSG_LOGIN_CRED);
			flash('LOGIN-ERROR', MSG_LOGIN_CRED);
			view("admin/auth/signin");
		} else if (!isset($this->env->vars['password']) or ($this->env->vars['password'] == '')) 
		{
			DEBUG::doLog('error login 2: ' . MSG_LOGIN_CRED);
			flash('LOGIN-ERROR', MSG_LOGIN_CRED);
			view("admin/auth/signin");
		} else {
			//check for login
			$auth = $this->auth->doAuth($this->env->vars['username'], $this->env->vars['password'], AUTH_ADMIN);
			if ($auth) {
				$this->currentUser = new userInfo($auth);
				$this->isLoggedIn = true;
				redirect(BASEPATH . '/'. ADMIN_CUSTOM_URL . '/post');
			} else {
				DEBUG::doLog('error login 3: ' . MSG_LOGIN_CRED);
				flash('LOGIN-ERROR', MSG_LOGIN_CRED);
				view("admin/auth/signin");
			}
		}
	}

	public function signout()
	{
		if (isset($_SESSION['Gkey']))  unset($_SESSION['Gkey']);
		if (isset($_SESSION['Gkey'])) session_destroy($_SESSION['Gkey']);
	
		$user = AdminUsers::update(['id' => $this->currentUser->id, 'tag' => '']);
		flash('LOGIN-ERROR', MSG_lOGOUT_SUCCESS);
		view("admin/auth/signin");  
	}


	protected function input_rules()
	{
		return [
			"user" => "required|min:6|max:20",
			"pass" => "required|min:6|max:20",
		];
	}

	protected function input_unfilterPostInputs()
	{
		return [
			"user",
			"pass"
		];
	}

	

}