<?php

namespace Core\Environment;


use \Core\Environment\Traits\RunEnvironmentTrait;
use \Core\Environment\Traits\FileValidtion;
use \Core\Environment\Traits\NumberValidtion;
use \Core\Environment\Traits\DateValidtion;
use \Core\Environment\Traits\StringValidtion;

class Environment
{

    use RunEnvironmentTrait,FileValidtion,NumberValidtion,DateValidtion,StringValidtion;
    //private $envModel;
    public $data = [];
    public $vars = [];
    public $varsWithoutPrefix = [];
    public $dbvars = [];
    public $unfilterGetInputs = [];
    public $unfilterPostInputs = [];

    public static $arrgeneral = array('#','WHERE','--','*','SLEEP','SELECT ','UNION','meshop','DROP',
                                ' OR ',' AND ','UPDATE ','DELETE ','JOIN','=','+','table','SET ',
                                "'",'"','PASSWORD','GRANT','information','CASE','CONCAT','0x','!',
                                '%23','schema','SUBSTR','script','language','LENGTH','database',
                                'version');    
    
   
    public Function __construct($rules=[],$unfilterGetInputs=[],$unfilterPostInputs=[])
    {
        $this->rules = $rules;
        $this->unfilterGetInputs = $unfilterGetInputs;
        $this->unfilterPostInputs = $unfilterPostInputs;
        $this->globalGetVars();
        $this->globalPostVars();
        $this->run();
    }

    public Function loadSetting($controller, $loadDefaultVars)
    {
        //load from DB
       //$envData = $this->envModel->getGlobalDBVars($controller, $loadDefaultVars);	
       
        // foreach($envData as $value)
        // {
        //   if ($value->varName!='') {
        //     $varName = 'dbvars_' .$value->varName;
        //     $this->$varName = $value->value;	
        //     $this->dbvars[$value->varName] = $value->value;
        //   }
        // }      
    }

    public function __isset($varName)
    {
        if (!array_key_exists($varName,$this->data)) return false;
        else return true;
    }

    public function __get($varName)
    {
        if (!array_key_exists($varName,$this->data)){
            //this attribute is not defined!
           trigger_error("$varName not exists",E_USER_NOTICE);
        }
        else return $this->data[$varName];
    }
  
    public function __set($varName,$value)
    {   
        $this->data[$varName] = $value;
    } 

    public Function globalPostVars()
    {
        global $env;
        $count=0;
        foreach ($_POST as $key => $postvalue)
        {    
            //checking posts variables
            $varName = 'vars_'.$key;
            if (in_array($key,$this->unfilterPostInputs))
            {
                $this->$varName =  $postvalue;//cleaning the value
            } else {
                $this->$varName =  self::cleanItem($postvalue);//cleaning the value
            }
            $this->vars[$key] = $this->$varName;
            $this->varsWithoutPrefix[$key] = $this->$varName;
            // unset($_POST[$postvalue]);
        }
       
    }

    public Function globalGetVars()
    {
        global $env;
        $count=0;
        foreach ($_GET as $key => $postvalue)
        {    
            //checking posts variables
            $varName = 'vars_'.$key;
            if (in_array($key,$this->unfilterGetInputs))
            {
                $this->$varName =  $postvalue;//cleaning the value
            } else {
                $this->$varName = self::cleanItem($postvalue);//cleaning the value
            }
            
            $this->vars[$key] = $this->$varName;
            $this->varsWithoutPrefix[$key] = $this->$varName;
            // unset($_GET[$postvalue]);
        }
    }

    public static Function cleanArray($array) 
    {
        $count=0;
        foreach ($array as $key => $value)
        {    
            //checking array elements
            $value = self::cleanItem($value); //replacing injections
            $array[$key] = $value;
        }
        return $array;
    }

    public static function cleanItem($value)
    {   
        global $mdb;

        if(get_magic_quotes_gpc()) $value=stripslashes($value); //clean
        $value = str_ireplace(self::$arrgeneral, '___', $value); //replacing injections
        return $value;
    }

    public function all()
    {   
        return $this->varsWithoutPrefix;
    }

    public function file($name)
    {
    	if( !isset($_FILES[$name]) || $_FILES[$name]['name'] === "") return null;
    	return $_FILES[$name];
    }

    protected function rules()
    {
        return [];
    }

    protected function unfilterGetInputs()
    {
        return [];
    }

    protected function unfilterPostInputs()
    {
        return [];
    }
}