<?php

namespace Core\Environment\Traits;


trait FileValidtion
{

	private function executeFileValidation($name, $ruleArray)
	{
		foreach ($ruleArray as $rule) 
		{
			if($rule == "required")
			{
				$this->fileRequire($name);
			}
			elseif(strpos($rule, "max:") === 0)
			{
				$this->fileMax($name, str_replace("max:", "", $rule));
			}
			elseif(strpos($rule, "min:") === 0)
			{
				$this->fileMin($name, str_replace("min:", "", $rule));
			}
			elseif(strpos($rule,"mimes:") === 0)
			{
				$this->fileMimes($name, str_replace("mimes:", "", $rule));
			}
			else
			{
				$this->ruleNotExistException($rule, $name);
			}
		}
	}


	private function fileRequire($name)
	{
		if( !$this->setAndNotNullFile($name) ) 
		{
			$this->setError($name, "$name file is require");
		}
	}


	private function fileMax($name, $value)
	{
		if( $this->setAndNotNullFile($name) ) 
		{
			//kb to byte
			$value = (int) $value * 1024;
			if($_FILES[$name]['size'] >= $value){

				$this->setError($name, "$name size must be lower than " . ($value / 1024) . " kb");
			}
		}
	}


	private function fileMin($name, $value)
	{
		if( $this->setAndNotNullFile($name) ) 
		{
			//kb to byte
			$value = (int) $value * 1024;
			if($_FILES[$name]['size'] <= $value){

				$this->setError($name, "$name size must be upper than " . ($value / 1024) . " kb");
			}
		}
	}


	private function fileMimes($name, $value)
	{
		if( $this->setAndNotNullFile($name) ) 
		{
			$mimesArray = explode(",", $value);
			if(!in_array(explode('/', $_FILES[$name]['type'])[1], $mimesArray)){
				$this->setError($name, "$name type must be " . implode($mimesArray , ', '));
			}
		}
	}


}