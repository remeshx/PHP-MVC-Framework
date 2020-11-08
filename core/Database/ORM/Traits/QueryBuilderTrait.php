<?php 

namespace Core\Database\ORM\Traits;


use PDO;
use PDOException;
use Core\Debug\DEBUG;
use Core\Database\Connection\PDOConnection;

trait QueryBuilderTrait
{

	private $sqlQuery = '';
	private $where = [];
	private $orderBy = [];
	private $limit = '';
	private $values = [];
	private $join = '';


	protected function setSql($query)
	{
		$this->sqlQuery .= $query;
	}

	protected function resetSql()
	{
		$this->sqlQuery = "";
	}

	protected function setJoin($table)
	{
		$this->join = " join $table ";
	}

	protected function setWhere($logicalOperator, $condition)
	{
		array_push($this->where, [ 'logicalOperator' => $logicalOperator, 'condition' => $condition ]);
	}

	protected function resetWhere()
	{
		$this->where = [];
	}

	protected function setOrderBy($attribute, $sort)
	{
		array_push($this->orderBy,  "$attribute  $sort" );
	}

	protected function resetOrderBy()
	{
		$this->orderBy = [];
	}

	protected function setLimit($from, $number)
	{
		$this->limit = " LIMIT ?, ? ";
		$this->addValue('from', $from);
		$this->addValue('number', $number);
	}

	protected function addValue($attribute, $value)
	{
		array_push($this->values, [ 'attribute' => $attribute, 'value' => $value ]);
	}

	protected function removeValues()
	{
		$this->values = [];
	}

	private function buildQuery()
	{
		$query = '';
		$query .= $this->sqlQuery;

		if(!empty($this->where))
		{
			$query .= " WHERE ";
			foreach ($this->where as $key => $where) 
			{
				$query .= $key != 0 ?  " {$where['logicalOperator']} {$where['condition']} " :  " {$where['condition']} "; 	
			}
		} 

		if(!empty($this->orderBy))
		{
			$query .= " ORDER BY ";
			$query .= implode(', ', $this->orderBy);
		}

		if($this->limit === '')
		{
			$query .= $this->limit;
		} 

		$query .= ";";
		if(PRINT_QUERY != false) echo $query."<hr/>" ;
		return $query;

	}

	protected function executeQuery()
	{
		$query = $this->buildQuery();
	

		$bindValues = $this->getBindValues();
		$pdoInstance = PDOConnection::getInstance();
		try
		{ 
			$statement = $pdoInstance->prepare($query);
			if ($statement)	$statement->execute($bindValues);
			else {
				DEBUG::doLog('Error query >' . $query);
				return false;
			}
			return $statement;
		}
		catch(PDOException $e)
		{
			$this->handle_sql_errors($query, $e->getMessage());
		}
	}

	private function getCount()
	{

	}

	private function getBindValues()
	{
		$data = [];
		foreach ($this->values as $value) {
			array_push($data, $value['value']);
		}
		return $data;
	}

	protected function fill($data)
	{
		$setValuesArray = [];
		if(isset($data[$this->primaryKey]))
		{
			unset($data[$this->primaryKey]);
			foreach (array_intersect($this->fillable, array_keys($data)) as $attribute) 
			{
				array_push($setValuesArray, " $attribute = ? ");
				$this->addValue($attribute, $data[$attribute]);
			}
			if($this->updatedAt !== null)
				$this->setSql(implode(', ', $setValuesArray).", $this->updatedAt = NOW() ");
			else
				$this->setSql(implode(', ', $setValuesArray));
		}else{
			foreach ($this->fillable as $attribute) 
			{
				array_push($setValuesArray, " $attribute = ? ");
				$this->addValue($attribute, $data[$attribute]);
			}
			if($this->createdAt !== null)
				$this->setSql(implode(', ', $setValuesArray).", $this->createdAt = NOW() ");
			else
				$this->setSql(implode(', ', $setValuesArray));
		}
	}
}