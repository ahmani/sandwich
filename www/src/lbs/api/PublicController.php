<?php

namespace lbs\api;

use lbs\common\model\Categorie;
use lbs\common\model\Ingredient;

Class PublicController
{

	public function getcategorie($req,$rs,$args)
	{
			    $cat = Categorie::where('id', '=', $args['id'])->firstOrFail();
			    $rs = $rs->withStatus(200)
			      ->withHeader('Content-Type', 'application/json;charset=utf8');
			    $rs->getBody()->write($cat->toJson());
	}

	public function getcategories($req,$rs,$args)
	{

			    $cat = Categorie::select()->get();
			    $rs = $rs->withStatus(200)
			      ->withHeader('Content-Type', 'application/json;charset=utf8');
			    $rs->getBody()->write($cat->toJson());
	}

	public function getingredient($req,$rs,$args)
	{
		try{
			$ing = Ingredient::where('id', '=', $args['id'])->firstOrFail();
			$catid = Categorie::where('id', '=', $ing['cat_id'])->firstOrFail();
			$ing['categorie'] = $catid;
			$rs = $rs->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf8');
				$rs->getBody()->write($ing->toJson());
		}catch(\Exception $e){
			return $this->json_error($rs, 404, $e->getMessage());
		}
	}

}
