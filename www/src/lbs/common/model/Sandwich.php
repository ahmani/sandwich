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
	protected  $id_commande;

	public $timestamps =false;

	public function size()
	{
		return $this->hasOne('lbs\common\model\size', 'id', 'id_size');
	} 	

	public function type()
	{
		return $this->hasOne('lbs\common\model\type','id', 'id_type');
	} 
	
	public function ingredients()
	{
		return $this->belongsToMany('lbs\common\model\Ingredient','ingredient_sandwich','id_sandwich','id_ingredient');
	}

	public function Commande(){
		return $this->belongsTo('lbs\common\model\Commande', 'id_commande');
	}
}
