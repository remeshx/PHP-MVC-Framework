<?php

namespace Core\User;

class userInfo {
    public $data;

    public function __construct($user)
    {
        $userVars = get_object_vars($user);
        foreach ($userVars as $key => $val) {
            $this->data[$key] = $val;
        }
    }

    public function __get($varName){
        if (!array_key_exists($varName,$this->data)){
            //this attribute is not defined!
           trigger_error("$varName not exists",E_USER_NOTICE);
        }
        else return $this->data[$varName];
    }
  
    public function __set($varName,$value){   
        $this->data[$varName] = $value;
    } 

    public function __isset($varName){
        if (!array_key_exists($varName,$this->data)) return false;
        else return true;
    }


}

?>