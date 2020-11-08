<?php

namespace Core\Auth;


class Authentication
{

    protected $Auth_type;
    
    public function __construct($Auth_type = AUTH_USER)
    {
        $this->Auth_type = $Auth_type;
    }

    public function isAuthorize()
    {
        $Gkey = checkUserSessionGkey();
        if( !$Gkey || $Gkey == '') return false;
        $user = \Core\Auth\Auth::getUserByGkey($Gkey, $this->Auth_type);
        if( !$user || !checkUserKeyIsValid($user)) return false;
        return $user;
    }

    public function doAuth($username, $password)
    {
        if(!isset($username) || $username == '') return false;
        if(!isset($password) || $password == '') return false;
        $username = trim(strtolower($username));
        $password = trim($password);
        $user = \Core\Auth\Auth::getUserByPassword($username, $password, $this->Auth_type);

        if(!$user) return false;
        if($this->createLoginEssential($user)) return $user;
        else return false;

    }

    // public function doAuthById($id)
    // {
    //     if(empty($id)) return false;
    //     $user = \Core\Auth\Auth::getUserById($username, $password, $this->Auth_type);

    //     if(!$user) return false;
    //     if($this->createLoginEssential($user)) return $user;
    //     else return false;

    // }

    public function createLoginEssential($user)
    {
        $Gkey = $this->getToken(6) . substr($user->id, -3);
        $logintime = date("YmdHis");
        if(\Core\Auth\Auth::registerUserLogin($user, $logintime, $Gkey, $this->Auth_type)) return false;
        createLoginSession($user, $Gkey);
        return true;
    }

    public function getToken($length = 32)
    {
        $token = "";

        $codeAlphabet = "123456789";
        if($this->Auth_type = AUTH_ADMIN)
        {
            $codeAlphabet .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
            $length = 32;
        }
        for ($i = 0; $i < $length; $i++)
        {
            $token .= $codeAlphabet[self::crypto_rand_secure(0, strlen($codeAlphabet))];
        }
        return $token;
    }

    public static function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if($range < 0) return $min;
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;
        do{
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        }while($rnd >= $range);
        return $min + $rnd;
    }
}