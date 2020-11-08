<?php

namespace Core\Debug;

//DebugLevel Constantcs 
define('E_NONE'         , 0);
// E_ERROR 
// E_WARNING 
// E_NOTICE 
// E_ALL 
// E_DEPRECATED 

Class Debug {
    //whol
    public $DebugLevel = DEBUG_LEVEL;
    public $DebugShow = DEBUG_SHOW;
    public $DebugLog =  DEBUG_LOG ;
    public $DebugFile   = 'DEBUG.LOG';

    public Function __construct()
    {
        $this->DebugLog = DEBUG_LOG;
        ini_set('display_errors', DEBUG_SHOW);

        if (DEBUG_LEVEL!='') {
            $this->DebugLevel = DEBUG_LEVEL;
            error_reporting(DEBUG_LEVEL);
            ini_set('error_reporting', DEBUG_LEVEL);
        }
    }

    static Function doLog($msg , $Debug_file='Debug.log')
    {
        if (!DEBUG_LOG) return false;
        $fname = '../logs/' . $Debug_file;
        $ti = date("Y-m-d H:i:s"); 
        if(file_exists($fname) && filesize($fname) > 20000000) {
            rename($fname, $fname.date("Y_m_d_H_i_s").'.log');
        }
        if (!($fout=fopen($fname,"ab")))  return false;
   
        fwrite($fout,"$ti - $msg\r\n");
  
		fclose($fout);
    } 

    static Function echoForIP($msg,$ip)
    {
        if ($_SERVER['REMOTE_ADDR']==$ip) echo $msg;
    }


}
?>