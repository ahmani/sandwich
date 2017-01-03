<?php

namespace lbs\common\model;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;

Class Ingredient extends Model
{
	protected  $table = "ingredient";
	protected  $primaryKey = "id" ;

	public $timestamps =false;

	/*la categorie d'une liste d'ingredients donnes*/
	public function categorie()
	{
		return $this->belongsTo('lbs\common\model\Categorie','cat_id');
	}
}
