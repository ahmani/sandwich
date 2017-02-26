<?php

namespace lbs\common\model;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;

Class Card extends Model
{
	protected  $table = "fidelity_card";
	protected  $primaryKey = "id" ;
	public $timestamps = false;
}
