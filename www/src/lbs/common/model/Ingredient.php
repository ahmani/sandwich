<?php

namespace lbs\common\model;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;

Class Ingredient extends Model
{
	protected  $table = "ingredient";
	protected  $primaryKey = "id" ;

	public $timestamps =false;

	public function categorie()
	{
		return $this->belongsTo('lbs\common\model\Categorie','cat_id');
	}
	public function sandwichs()
	{
		return $this->belongsToMany('lbs\common\model\sandwich','ingredient_sandwich',
			'id_ingredient','id_sandwich');
	}
}
