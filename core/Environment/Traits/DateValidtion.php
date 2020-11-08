<?php

namespace Core\Environment\Traits;


trait DateValidtion
{

	public function executeDateValidation($name, $ruleArray)
	{
		foreach ($ruleArray as $rule) 
		{
			$this->checkDate($name);
			if($rule == "required")
			{
				$this->dateRequire($name);
			}
			elseif(strpos($rule, "max:") === 0)
			{
				$this->dateMax($name, str_replace("max:", "", $rule));
			}
			elseif(strpos($rule, "min:") === 0)
			{
				$this->dateMin($name, str_replace("min:", "", $rule));
			}
			elseif(strpos($rule, "exists:") === 0)
			{
				$rule = str_replace("exists:", "", $rule);
                $rule = explode(",", $rule);
                $key = isset($rule[1]) == false ? null : $rule[1];
                $this->dateExistsIn($name, $rule[0], $key);
			}
			elseif(strpos($rule, "unique:") === 0)
			{
				$rule = str_replace("unique:", "", $rule);
                $rule = explode(",", $rule);
                $key = isset($rule[1]) == false ? null : $rule[1];
                $this->dateUnique($name, $rule[0], $key);
			}
			else
			{
				$this->ruleNotExistException($rule, $name);
			}
		}
	}

	private function dateRequire($name)
	{
		if( !$this->setAndNotNull($name) ) 
		{
			$this->setError($name, "$name is require");
		}
	}


	private function checkDate($name)
	{
		if( $this->setAndNotNull($name) ) 
		{
			if(!validateDate($this->varsWithoutPrefix[$name]))
			{
				$this->setError($name, "$name must be number");
			}
		}
	}


	private function dateMax($name, $value)
	{
		if( $this->setAndNotNull($name) )
		{
			if(strtotime($this->varsWithoutPrefix[$name]) >= strtotime($value))
			{

				$this->setError($name, "$name must be lower than $value");
			}
		}
	}


	private function dateMin($name, $value)
	{
		if( $this->setAndNotNull($name) )
		{
			if(strtotime($this->varsWithoutPrefix[$name]) <= strtotime($value))
			{

				$this->setError($name, "$name must be upper than $value");
			}
		}
	}


    private function dateExistsIn($name, $table, $field = "id" )
    {
        if( $this->setAndNotNull($name) )
        {
            $value = $this->$name;
            $sql = "SELECT COUNT(*) FROM $table WHERE $field = ?";
            $statement = $this->executeQuery($sql, [$value]);
            $result = $statement->fetchAll();
            if(count($result) == 0 || $result === false) {
                $this->setError($name, "$name not already exist");
            }
        }
    }

    private function dateUnique($name, $table, $field = "id" )
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