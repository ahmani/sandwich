<?php

namespace lbs\common\model;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;

Class Sandwich extends Model
{
	protected  $table = "sandwich";
	protected  $primaryKey = "id" ;
	protected  $id_size;
	protected  $id_type;

	public $timestamps =false;

	public function sizes()
	{
		return $this->hasMany('lbs\common\model\size','id_size');
	}
	public function types()
	{
		return $this->hasMany('lbs\common\model\type','id_type');
	}
	public function ingredients()
	{
		return $this->belongsToMany('lbs\common\model\Ingredient','ingredient_sandwich','id_sandwich','id_ingredient');
	}

	public function Commande(){
		return $this->belongsTo('lbs\common\model\Commande', 'id_commande');
	}
}
