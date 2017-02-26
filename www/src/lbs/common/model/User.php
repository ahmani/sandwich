<?php

namespace lbs\common\model;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;

Class User extends Model
{
	protected  $table = "user";
	protected  $primaryKey = "id" ;
	protected $hidden = ['password'];
	public $timestamps =false;
}
