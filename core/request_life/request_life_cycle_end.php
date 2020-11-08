<?php

//unset last_flash_message
if (isset($_SESSION["systemLastFlashMessage"])) 
{
	unset($_SESSION["systemLastFlashMessage"]);
}
//unset last_error_message
if (isset($_SESSION["systemLastErrorMessage"])) 
{
	unset($_SESSION["systemLastErrorMessage"]);
}
//unset old_request_params
if(isset($_SESSION["systemOldRequestParams"]))
{
	unset($_SESSION["systemOldRequestParams"]);
}
// set next old_request_params and unset_request_params
if(isset($_SESSION["systemRequestParams"]))
{
	$_SESSION["systemOldRequestParams"] = $_SESSION["systemRequestParams"];
	unset($_SESSION["systemRequestParams"]);
}
