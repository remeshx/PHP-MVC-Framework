<?php

namespace Core\Auth;


//use Core\Database\ORM\Model;
use \App\Model\Admin\AdminUsers;

class Auth 
{
    static function getUserByPassword($username, $password, $authType='')
    {
        $password = hash('sha256', hash('sha256', $password));
        if($authType == AUTH_ADMIN)
        {
            $user = AdminUsers::where('userNam', $username)->where("passWor", $password)->get();
        } else {
            $user = \App\Model\Users::where('userNam', $username)->where("passWor", $password)->get();
        }
        return count($user) <= 0 ? false : $user[0];
    }

    static function registerUserLogin($user, $loginTime, $Gkey, $authType = '')
    {
        if($authType == AUTH_ADMIN) 
        {
            $user = AdminUsers::update(['id' => $user->id, 'tag' => $Gkey, 'lastVisit' => $loginTime, 'loginTime' => $loginTime]);
        }
        else 
        {
            $user = \App\Model\Users::update(['id' => $user->id, 'tag' => $Gkey, 'lastVisit' => $loginTime, 'loginTime' => $loginTime, 'shobeId' => 0, 'SID' => 0]);
        }

        return ($user)?  false : true;
    }

    static function getUserByGKey($GKey, $authType='')
    {
        if($authType == AUTH_ADMIN)
        {
            $user = AdminUsers::where('tag', $GKey)->get();
        } else {
            $user = \App\Model\Users::where('tag', $GKey)->get();
        }
        return count($user) <= 0 ? false : $user[0];
    }

    static function getUserById($id, $authType='')
    {
        if($authType == AUTH_ADMIN)
        {
            $user = AdminUsers::where('id', $id)->get();
        } else {
            $user = \App\Model\Users::where('id', $id)->get();
        }
        return count($user) <= 0 ? false : $user[0];
    }

    static function __callStatic($method, $args)
    {
        $instance = new self();
        return call_user_func_array([$instance, $method], $args);
    }


}