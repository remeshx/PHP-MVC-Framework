<?php

namespace App\Model;


use Core\Database\ORM\Model;
use Core\Database\ORM\Traits\SoftDeleteTrait;


class Post extends Model
{
	use SoftDeleteTrait;
	
	protected $fillable = ['title', 'body', 'cat_id', 'image'];
	protected $primaryKey = 'id';
	protected $table = 'posts';
	protected $createdAt = 'created_at';
	protected $updatedAt = 'updated_at';
	protected $deletedAt = 'deleted_at';

}