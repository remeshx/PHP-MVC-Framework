<?php

namespace Core\Router;

class Routing
{

	public function execute()
	{
		global $routes,$currentRoute;
		$routes->setBasePath(BASEPATH);

		//load route files
		foreach (glob("../resource/route/*.php") as $file)
		{
			$filename = basename($file, ".php");
			$routes->setRouteContentType($filename);
		    require_once $file;
		}
		
		//find match route
		$match = $routes->match();
		
		$currentRoute = $match;
		if(is_array($match))
		{
			$target = explode('#', $match['target']);
			$ctrl = explode('/', $target[0]);

			if(count($ctrl) > 1)
			{
				$last_node = count($ctrl) - 1;
				$currentController = $ctrl[$last_node];
				unset($ctrl[$last_node]);
				$currentDirectory = implode('/', $ctrl) . '/';
			}else{
				$currentController = $target[0];
			}

			$currentController = "\App\Controller\\".$currentController;
			$currentMethod = $target[1];
			$params = $match['params'];
			$contentType = $match['contentType'];
			if(CSRF == 1 && methodField() == 'POST' && $contentType != "api" && $contentType != "cron")
			{

				// echo  $_SESSION['token'] .' = '. $_POST['token'];exit;
				if(!isset($_POST['token']) || !isset($_SESSION['token']) || $_SESSION['token'] != $_POST['token'] || time() >= $_SESSION['token-expire']){
					echo "401 - expire";exit;
				}else{
					$object = new $currentController();
					call_user_func_array([$object, $currentMethod], $params);
				}				
			}else{
				$object = new $currentController();
				call_user_func_array([$object, $currentMethod], $params);
			}

		}else{
			echo "404 exit";
			exit;
		}
	}
	
}