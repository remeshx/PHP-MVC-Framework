<?php

namespace Core\Environment\Traits;


trait StringValidtion
{

	public function executeStringValidation($name, $ruleArray)
	{
		
		foreach ($ruleArray as $rule) 
		{
			if($rule == "required")
			{
				$this->stringRequire($name);
			}
			elseif($rule == "email")
			{
				$this->stringEmail($name);
			}
			elseif(strpos($rule, "max:") === 0)
			{
				$this->stringMax($name, str_replace("max:", "", $rule));
			}
			elseif(strpos($rule, "min:") === 0)
			{
				$this->stringMin($name, str_replace("min:", "", $rule));
			}
			elseif(strpos($rule, "exists:") === 0)
			{
				$rule = str_replace("exists:", "", $rule);
                $rule = explode(",", $rule);
                $key = isset($rule[1]) == false ? null : $rule[1];
                $this->stringExistsIn($name, $rule[0], $key);
			}
			elseif(strpos($rule, "unique:") === 0)
			{
				$rule = str_replace("unique:", "", $rule);
                $rule = explode(",", $rule);
                $key = isset($rule[1]) == false ? null : $rule[1];
                $this->stringUnique($name, $rule[0], $key);
			}
			elseif(strpos($rule, "regex:") === 0)
			{
                $this->stringRegex($name, str_replace("regex:", "", $rule));
			}
			else
			{
				$this->ruleNotExistException($rule, $name);
			}

		}
	}


	private function stringRequire($name)
	{
		if( !$this->setAndNotNull($name) ) 
		{
			$this->setError($name, "$name is require");
		}
	}

	private function stringEmail($name)
	{
		if( $this->setAndNotNull($name) )
		{
			if (!filter_var($this->varsWithoutPrefix[$name], FILTER_VALIDATE_EMAIL)) 
			{
				$this->setError($name, "$name must be email format");
			}
		}
	}


	private function stringMax($name, $value)
	{
		if( $this->setAndNotNull($name) )
		{
			if(strlen($this->varsWithoutPrefix[$name]) >= (int) $value){

				$this->setError($name, "$name size must be lower than $value charachters");
			}
		}
	}


	private function stringMin($name, $value)
	{
		if( $this->setAndNotNull($name) )
		{
			if(strlen($this->varsWithoutPrefix[$name]) <= (int) $value){

				$this->setError($name, "$name size must be upper than $value charachters");
			}
		}
	}

	private function stringExistsIn($name, $table, $field = "id" )
    {
        if( $this->setAndNotNull($name) )
		{
            $value = $this->varsWithoutPrefix[$name];
            $sql = "SELECT COUNT(*) FROM $table WHERE $field = ?";
            $statement = $this->executeQuery($sql, [$value]);
            $result = $statement->fetchAll();
            if(count($result) == 0 || $result === false) {
                $this->setError($name, "$name not already exist");
            }
        }
    }

    private function stringUnique($name, $table, $field = "id" )
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

    private function stringRegex($name, $pattern)
    {
    	$string = $this->varsWithoutPrefix[$name];
    	//   (?!([A-Za-z0-9])).
    	// $pattern = '/'.trim($pattern, '/').'/';
    	$pattern = '/(?!('.trim($pattern, '/').'))./';
    	if( $this->setAndNotNull($name) )
		{
			if(is_int(@preg_match($pattern, '')))
			{
				if(preg_match($pattern, $string)) 
				{
					$this->setError($name, "$name pattern not match");
				}
			}else{
				throw new \Exception("validation pattern is invalid!", 1);
			}
        }
    }
}