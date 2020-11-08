<?php


/** 
*---------------------------------------------------
* veiw method return template html codes
*---------------------------------------------------
*/
function view($dir, $vars = [])
{
	$renderView = new \Core\View\RenderView();
	$content = $renderView->run($dir);
	extract($content['providerValues']);
	extract($vars);
	eval("?> ".html_entity_decode($content['content']));
	exit;
	// include "../app/view/$dir.php";
}