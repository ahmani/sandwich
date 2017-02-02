<?php

namespace lbs\common\model;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;

Class Size extends Model
{
	protected  $table = "size";
	protected  $primaryKey = "id" ;

	public $timestamps =false;

	public function sandwich()
	{
		return $this->belongsTo('lbs\common\model\sandwich','id_size');
	}
}
