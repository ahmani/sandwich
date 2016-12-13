<?php

namespace lbs\common\model;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;

Class Ingredient extends Model
{
	protected  $table = "ingredient";
	protected  $primaryKey = "id" ;


	public $timestamps =false;
}
