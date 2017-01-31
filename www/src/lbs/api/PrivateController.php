<?php

namespace lbs\api;

use lbs\common\model\Categorie;
use lbs\common\model\Ingredient;
use lbs\common\model\Commande;
use lbs\common\model\size;
use lbs\common\model\type;
use lbs\common\model\Sandwich;

Class PrivateController
{

	private $cont;

	public function __construct($var)
	{
		$this->cont= $var;
	}

	public function getcommandes($req,$rs,$args)
	{
		$cat = Commande::select()->get();
		$rs = $rs->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf8');
		$col = array();
		$commandes = json_decode($cat->toJson());

		foreach ($commandes as $value) {
			$tab = GetSandwichsByCommande($value->id);
		}

	}



}
