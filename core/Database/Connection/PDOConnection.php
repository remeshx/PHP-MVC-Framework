<?php

namespace Core\Database\Connection;

use PDO;

class PDOConnection
{

	private static $instance;

	private function __construct()
	{
		//fetch array by PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		$options = [
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
		    PDO::ATTR_EMULATE_PREPARES   => false,
		];
		self::$instance = new PDO('mysql:host='.DBHOST.';dbname='.DBName, DBUsername, DBPassword, $options);
	}


	public static function getInstance()
	{
		if(empty(self::$instance))
		{
			new self;
		}
		return self::$instance;
	}

	public static function last_insert_id()
	{
		return self::getInstance()->lastInsertId();
	}

}