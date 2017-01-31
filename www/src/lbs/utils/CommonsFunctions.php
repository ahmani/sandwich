<?php


use lbs\common\model\Ingredient;
use lbs\common\model\Commande;
use lbs\common\model\Size;
use lbs\common\model\Type;
use lbs\common\model\Sandwich;
use lbs\common\model\Categorie;

function GetSandwichsByCommande($id_commande)
{
	$response = array();
	$sandwichs = Sandwich::where("id_commande","=",$id_commande)->get();
	foreach ($sandwichs as $key => $value) {
		foreach ($value->ingredients as $val) {
			$cat = categorie::where('id', '=', $val->cat_id)->firstOrFail();
			$array[$cat->nom] = $val->nom;
		}
		$response[$key] = array('Taille' => Size::where('id', '=', $value->id_size)->firstOrFail()->nom,
				        	  'Type' => Type::where('id', '=', $value->id_type)->firstOrFail()->nom,
				        	  'ingredients' => $array);
	}
	return $response;
}