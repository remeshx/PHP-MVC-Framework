<?php

namespace Core\Database\ORM;


use Core\Database\ORM\Traits\CRUDTrait;
use Core\Database\ORM\Traits\QueryBuilderTrait;
use Core\Database\ORM\Traits\MethodCallerTrait;
use Core\Database\ORM\Traits\RunQueryTrait;
use Core\Database\ORM\Traits\TransactionTrait;

class Model
{
	use CRUDTrait,QueryBuilderTrait,MethodCallerTrait,RunQueryTrait;
} 