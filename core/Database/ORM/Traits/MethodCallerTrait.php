<?php

namespace Core\Database\ORM\Traits;


trait MethodCallerTrait
{
	private $allMethods = ['create', 'update', 'delete', 'find', 'all', 
		'where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'whereCondition', 'orderBy', 'limit' , 'get'];
	private $allowedMethods = ['create', 'update', 'delete', 'find', 'all', 
		'where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'whereCondition', 'orderBy', 'limit' , 'get'];


	public function __call($method, $args)
	{
		return $this->run($method, $args);
	}

	public static function __callStatic($method, $args)
	{
		$calledClass = get_called_class();
		$instance = new $calledClass();
		return $instance->run($method, $args);
	}

	private function run($method, $args)
	{
		if(in_array($method, $this->allowedMethods))
		{
			$postfix = "Method";
			$methodName = $method.$postfix;	
			return call_user_func_array([$this, $methodName], $args);
		}
	}

	private function setAllowedMethods($array)
	{
		$this->allowedMethods = $array;
	}
}