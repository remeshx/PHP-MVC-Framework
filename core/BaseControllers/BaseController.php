<?php

namespace Core\BaseControllers;

use \Core\Environment\Environment;


class BaseController 
{
    
	public function __Construct()
	{
        $this->getEnviroment();
	}
    
    protected function getEnviroment()
    {
        $this->env = new Environment($this->input_rules(),$this->input_unfilterGetInputs(),$this->input_unfilterPostInputs());
    }

	protected function input_rules()
	{
		return [];
	}

	protected function input_unfilterGetInputs()
	{
		return [];
	}

	protected function input_unfilterPostInputs()
	{
		return [];
	}
}