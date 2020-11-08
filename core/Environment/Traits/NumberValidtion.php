<?php

namespace Core\Environment\Traits;


trait NumberValidtion
{

	public function executeNumberValidation($name, $ruleArray)
	{
		$this->checkNumber($name);
		foreach ($ruleArray as $rule) 
		{
			if($rule == "required")
			{
				$this->numberRequire($name);
			}
			elseif(strpos($rule, "max:") === 0)
			{
				$this->numberMax($name, str_replace("max:", "", $rule));
			}
			elseif(strpos($rule, "min:") === 0)
			{
				$this->numberMin($name, str_replace("min:", "", $rule));
			}
			elseif(strpos($rule, "exists:") === 0)
			{
				$rule = str_replace("exists:", "", $rule);
                $rule = explode(",", $rule);
                $key = isset($rule[1]) == false ? null : $rule[1];
                $this->numberExistsIn($name, $rule[0], $key);
			}
			elseif(strpos($rule, "unique:") === 0)
			{
				$rule = str_replace("unique:", "", $rule);
                $rule = explode(",", $rule);
                $key = isset($rule[1]) == false ? null : $rule[1];
                $this->numberUnique($name, $rule[0], $key);
			}
			else
			{
				$this->ruleNotExistException($rule, $name);
			}
		}

	}


	private function numberRequire($name)
	{
		if( !$this->setAndNotNull($name) ) 
		{
			$this->setError($name, "$name is require");
		}
	}


	private function checkNumber($name)
	{
		if( $this->setAndNotNull($name) ) 
		{
			if( !is_numeric($this->varsWithoutPrefix[$name]) ) 
			{
				$this->setError($name, "$name must be number");
			}
		}
	}


	private function numberMax($name, $value)
	{
		if( $this->setAndNotNull($name) )
		{
			if((int) $this->varsWithoutPrefix[$name] >= (int) $value){

				$this->setError($name, "$name must be lower than $value");
			}
		}
	}


	private function numberMin($name, $value)
	{
		if( $this->setAndNotNull($name) )
		{
			if((int) $this->varsWithoutPrefix[$name] <= (int) $value){

				$this->setError($name, "$name must be upper than $value");
			}
		}
	}


    private function numberExistsIn($name, $table, $field = "id" )
    {
        if( $this->setAndNotNull($name) )
        {
            $value = $this->varsWithoutPrefix[$name];
            $sql = "SELECT COUNT(*) as count FROM $table WHERE $field = ?";
            $statement = $this->executeQuery($sql, [$value]);
            $result = $statement->fetch();
            if($result->count == 0 || $result === false) {
                $this->setError($name, "$name not already exist");
            }
        }
    }

    private function numberUnique($name, $table, $field = "id" )
    {
        if( $this->setAndNotNull($name) )
		{
            $value = $this->varsWithoutPrefix[$name];
            $sql = "SELECT COUNT(*) as count FROM $table WHERE $field = ?";
            $statement = $this->executeQuery($sql, [$value]);
            $result = $statement->fetch();
            if($result->count != 0 ) {
                $this->setError($name, "$name must be unique");
            }
        }
    }
    
}