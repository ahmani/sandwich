<?php

namespace lbs\common\model;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;

Class Categorie extends Model
{
	protected  $table = "categorie";
	protected  $primaryKey = "id" ;
	public $timestamps =false;

  /*les ingredients d'une categorie*/
	public function ingredients()
	{
		return $this->hasMany('lbs\common\model\Ingredient','cat_id');
	}
}
