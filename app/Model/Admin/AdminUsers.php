<?php

namespace App\Model\Admin;

use \Core\Database\ORM\Model;
use \Core\Database\ORM\Traits\SoftDeleteTrait;


class AdminUsers extends Model
{
	
	protected $fillable = ['tag', 'lastVisit', 'loginTime', 'shobeId', 'SID'];
	protected $primaryKey = 'id';
	protected $table = DB_TBL_PREFIX . 'admin_users';
	protected $createdAt = 'dateRegistered';
	protected $updatedAt = 'lastVisit';
	protected $deletedAt = 'deleted_at';

}