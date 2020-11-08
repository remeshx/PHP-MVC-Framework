<?php

namespace App;

use Core\View\RenderViewProvider;

class ViewProvider extends RenderViewProvider
{

	public function boot()
	{
		global $currentRoute;
		
		if($currentRoute['contentType'] == "web")
		{
			$this->view("*", function(){
				return [
					'categories' => \App\Model\Category::all()
				];
			});
		}
	}

}