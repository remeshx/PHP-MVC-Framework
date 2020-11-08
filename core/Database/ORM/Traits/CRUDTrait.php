<?php

namespace Core\Database\ORM\Traits;


use Core\Database\Connection\PDOConnection;

trait CRUDTrait
{

	protected $fillable = [];
	protected $primaryKey = 'id';
	protected $table = '';
	protected $createdAt = 'created_at';
	protected $updatedAt = 'updated_at';
	protected $deletedAt = null;

	protected function createMethod($data)
	{
		$this->setSql("INSERT {$this->table} SET ");
		$this->fill($data);
		$this->executeQuery();
		$this->resetSql();
		$this->removeValues();
		return $this->findMethod(PDOConnection::last_insert_id());
	}

	protected function updateMethod($data)
	{
		$this->setSql("UPDATE {$this->table} SET ");
		$this->fill($data);
		$this->setWhere("AND", "$this->primaryKey = ?");
		$this->addValue($this->primaryKey, $data[$this->primaryKey]);
		$this->executeQuery();
		$this->resetSql();
		$this->removeValues();
		$this->resetWhere();
		return $this->findMethod($data[$this->primaryKey]);
	}

	protected function deleteMethod($id)
	{
		$this->setSql("DELETE FROM {$this->table} ");
		$this->setWhere("AND", "$this->primaryKey = ?");
		$this->addValue($this->primaryKey, $id);
		$this->executeQuery();
	}

	protected function findMethod($id)
	{
		$this->setSql("SELECT * FROM {$this->table} ");
		$this->setWhere("AND", "$this->primaryKey = ?");
		$this->addValue($this->primaryKey, $id);
		$result = $this->executeQuery();
		return $result->fetch();
	}

	protected function allMethod()
	{
		$this->setSql("SELECT * FROM {$this->table} ");
		$result = $this->executeQuery();
		return $result->fetchAll();
	}

	protected function whereMethod($attribute, $firstValue, $secondValue = null)
	{
		if($secondValue === null)
		{
			$this->setWhere("AND", "$attribute = ?");
			$this->addValue($attribute, $firstValue);
		}else{
			$this->setWhere("AND", "$attribute $firstValue ?");
			$this->addValue($attribute, $secondValue);
		}
		$this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'whereCondition', 'orderBy', 'limit' , 'get']);
		return $this;
	}

	protected function whereOrMethod($attribute, $firstValue, $secondValue = null)
	{
		if($secondValue === null)
		{
			$this->setWhere("OR", "$attribute = ?");
			$this->addValue($attribute, $firstValue);
		}else{
			$this->setWhere("OR", "$attribute $firstValue ?");
			$this->addValue($attribute, $secondValue);
		}
		$this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'whereCondition', 'orderBy', 'limit' , 'get']);
		return $this;
	}

	protected function whereNullMethod($attribute)
	{
		$this->setWhere("AND", "$attribute IS NULL");
		$this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'whereCondition', 'orderBy', 'limit' , 'get']);
		return $this;
	}

	protected function whereNotNullMethod($attribute)
	{
		$this->setWhere("AND", "$attribute IS NOT NULL");
		$this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'whereCondition', 'orderBy', 'limit' , 'get']);
		return $this;
	}

	protected function whereInMethod($attribute, $data)
	{
		$inCondition = '';
		foreach ($data as $key => $value) {
			$inCondition .= $key == 0 ? ' ? ' : ', ? ';
			$this->addValue($attribute, $value);
		}
		$this->setWhere("AND", "$attribute IN ( $inCondition ) ");
		$this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'whereCondition', 'orderBy', 'limit' , 'get']);
		return $this;
	}

	protected function whereConditionMethod($sqlQuery)
	{
		$this->setWhere("AND", $sqlQuery);
		$this->setAllowedMethods(['where', 'whereOr', 'whereIn', 'whereNull', 'whereNotNull', 'whereCondition', 'orderBy', 'limit' , 'get']);
		return $this;
	}

	protected function orderByMethod($attribute, $sort = 'DESC')
	{
		$this->setOrderBy($attribute, $sort);
		$this->setAllowedMethods(['orderBy', 'limit' , 'get']);
		return $this;
	}

	protected function limitMethod($from, $number)
	{
		$this->setLimit($from, $number);
		$this->setAllowedMethods(['limit' , 'get']);
	}

	protected function getMethod($args = [])
	{
		empty($args) === true ? $this->setSql("SELECT * FROM {$this->table} ") : $this->setSql("SELECT ".implode(', ', $args)." FROM {$this->table} ");
		$result = $this->executeQuery();
		return $result->fetchAll();
	}

}