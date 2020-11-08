<?php

namespace Core\Database\ORM\Traits;


use Core\Database\Connection\PDOConnection;

trait RunQueryTrait
{

	protected function execute($query, $args = [])
	{
		$pdoInstance = PDOConnection::getInstance();
		$statement = $pdoInstance->prepare($query);
		empty($args) ? $statement->execute() : $statement->execute($args);
		return $statement;
	}
}