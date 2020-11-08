<?php

namespace Core\Database\ORM\Traits;


trait SoftDeleteTrait
{
	protected function updateMethod($data)
	{
		$this->setSql("UPDATE {$this->table} SET ");
		$this->fill($data);
		$this->setWhere("AND", "$this->primaryKey = ?");
		$this->addValue($this->primaryKey, $data[$this->primaryKey]);
		$this->setWhere("AND", "$this->deletedAt IS NULL");
		$this->executeQuery();
		$this->resetSql();
		$this->removeValues();
		$this->resetWhere();
		return $this->findMethod($data[$this->primaryKey]);
	}

	protected function deleteMethod($id)
	{
		$this->setSql("UPDATE {$this->table} SET {$this->deletedAt} = NOW() ");
		$this->setWhere("AND", "$this->primaryKey = ?");
		$this->addValue($this->primaryKey, $id);
		$this->executeQuery();
	}

	protected function findMethod($id)
	{
		$this->setSql("SELECT * FROM {$this->table} ");
		$this->setWhere("AND", "$this->primaryKey = ?");
		$this->addValue($this->primaryKey, $id);
		$this->setWhere("AND", "$this->deletedAt IS NULL");
		$result = $this->executeQuery();
		return $result->fetch();
	}

	protected function allMethod()
	{
		$this->setSql("SELECT * FROM {$this->table} ");
		$this->setWhere("AND", "$this->deletedAt IS NULL");
		$result = $this->executeQuery();
		return $result->fetchAll();
	}

	protected function getMethod($args = [])
	{
		empty($args) === true ? $this->setSql("SELECT * FROM {$this->table} ") : $this->setSql("SELECT ".implode(', ', $args)." FROM {$this->table} ");
		$this->setWhere("AND", "$this->deletedAt IS NULL");
		$result = $this->executeQuery();
		return $result->fetchAll();
	}
}