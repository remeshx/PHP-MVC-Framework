<?php

namespace App\Model;


use Core\Database\ORM\Model;
use Core\Database\ORM\Traits\SoftDeleteTrait;


class Category extends Model
{
	// use SoftDeleteTrait;
	
	protected $fillable = ['name'];
	protected $primaryKey = 'id';
	protected $table = 'categories';
	protected $createdAt = 'created_at';
	protected $updatedAt = 'updated_at';
	// protected $deletedAt = 'deleted_at';

	public function posts($id)
	{
		$query = "SELECT posts.* FROM categories join posts on categories.id=posts.cat_id WHERE categories.id = ?";
		$statement = $this->execute($query, [$id]);
		return $statement->fetchAll();
	}
}