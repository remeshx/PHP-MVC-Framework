<?php

namespace Core\View;


class RenderViewProvider
{
	protected $currentViewName;
	protected $providerValues = [];
	protected $visitedViews = [];
	
	public function setCurrentViewName($name)
	{
		$this->currentViewName = $name;
	}

	public function getCurrentViewName()
	{
		return $this->currentViewName;
	}
	
	protected function view($name, $callback)
	{
		if($this->getCurrentViewName() == $name || $name == "*")
		{
			if(!in_array($name, $this->visitedViews))
			{
				foreach ($callback() as $key => $value) {
					$this->providerValues[$key] = $value;
				}
				$this->addVisitedViews($name);
			}
		}
	}

	protected function addVisitedViews($name)
	{
		array_push($this->visitedViews, $name);
	}

	public function getProviderValues()
	{
		return $this->providerValues;
	}
}