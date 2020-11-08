<?php

namespace Core\Database\Transactions;


use \Core\Database\Connection\PDOConnection;

class Transaction
{

	public static function beginTransaction()
	{
		$pdoInstance = PDOConnection::getInstance();
		$pdoInstance->beginTransaction();
	}

	public static function commit()
	{
		$pdoInstance = PDOConnection::getInstance();
		try
		{
			$pdoInstance->commit();
		} 
		catch (\Exception $e) {
		    if ($pdoInstance->inTransaction()) {
		        $pdoInstance->rollback();
		    }
		    throw $e;
		}
	}
	
}