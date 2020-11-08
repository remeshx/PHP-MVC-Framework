<?php

namespace Core\Environment\Traits;


use PDO;
use Core\Database\Connection\PDOConnection;

trait RunEnvironmentTrait
{

	private $errorExists = false;
	private $errorElementArray = [];

	protected function run()
	{
		$rules = $this->rules();
		foreach ($rules as $name => $rule) 
		{
			$ruleArray = explode("|", trim($rule, " |"));
			if(in_array("file", $ruleArray))
			{
				unset($ruleArray[array_search("file", $ruleArray)]);
				$this->executeFileValidation($name, $ruleArray);
			}
			elseif(in_array("number", $ruleArray))
			{
				unset($ruleArray[array_search("number", $ruleArray)]);
				$this->executeNumberValidation($name, $ruleArray);
			}
			elseif(in_array("date", $ruleArray))
			{
				unset($ruleArray[array_search("date", $ruleArray)]);
				$this->executeDateValidation($name, $ruleArray);
			}
			else
			{
				$this->executeStringValidation($name, $ruleArray);
			}
		}

		if($this->errorExists === true)
		{
			global $currentRoute;
			if($currentRoute['contentType'] === "api")
			{
				$allErrorsWithoutRedirect = $_SESSION['systemErrorMessage'];
				unset($_SESSION['systemErrorMessage']);
				response([
					'status' => 'error',
					'errors' => $allErrorsWithoutRedirect
				]);
				exit;
			}
			else
			{
				return back();
			}			
			// dd($_SESSION['systemErrorMessage']);
		}

	}

	protected function setErrorExist()
	{
		$this->errorExists = true;
	}

	protected function setErrorElement($name)
	{
		array_push($this->errorElementArray, $name);
	}

	protected function checkErrorElement($name)
	{
		return in_array($name, $this->errorElementArray);
	}

	protected function setError($name, $message)
	{
		$this->setErrorExist();
		if(!$this->checkErrorElement($name))
		{
			$this->setErrorElement($name);
			error($name, $message);
		}
	}

	protected function executeQuery($query, $values = [])
	{
		$pdoInstance = PDOConnection::getInstance();
		$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try
		{ 
		    $statement = $pdoInstance->prepare($query);
			empty($values) ? $statement->execute() : $statement->execute($values);
			return $statement;
		}
		catch(PDOException $e)
		{
			handle_sql_errors($query, $e->getMessage());
		}
	}

	protected function setAndNotNull($name)
	{
		return (isset($this->varsWithoutPrefix[$name]) && $this->varsWithoutPrefix[$name] !== "") ? true : false;
	}

	protected function setAndNotNullFile($name)
	{
		return (isset($_FILES[$name]) && $_FILES[$name]['name'] !== "") ? true : false;
	}

	protected function ruleNotExistException($rule, $name)
	{
		$class = get_called_class();
		throw new \Exception('"'.$rule.'" not exists in "'.$class.'" class, "'.$name.'" field  validation rules.');
	}
}