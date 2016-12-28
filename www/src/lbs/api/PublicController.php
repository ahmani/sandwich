<?php

namespace lbs\api;

use lbs\common\model\Categorie;
use lbs\common\model\Ingredient;

Class PublicController
{

	private $cont;

	public function __construct($var)
	{
		$this->cont= $var;
	}
	public function getcategorie($req,$rs,$args)
	{
			    $cat = Categorie::where('id', '=', $args['id'])->firstOrFail();
			    $rs = $rs->withStatus(200)
			      ->withHeader('Content-Type', 'application/json;charset=utf8');
			    $rs->getBody()->write($cat->toJson());
	}

	public function getcategories($req,$rs,$args)
	{
<<<<<<< HEAD

			    $cat = Categorie::select()->get();
			    $rs = $rs->withStatus(200)
			      ->withHeader('Content-Type', 'application/json;charset=utf8');
			    $rs->getBody()->write($cat->toJson());
=======
				$col = array();
			    $cat = Categorie::select()->get();
			    $rs = $rs->withStatus(200)
			      		 ->withHeader('Content-Type', 'application/json;charset=utf8');

			    $cats = json_decode($cat->toJson());

			    foreach ($cats as $cat) {

			      	array_push($col, ['categorie' => (array)$cat,
			      					  'links' => ['self' =>
			      					  ['href' => $this->cont['router']->pathFor('categorie',['id' => $cat->id])]]]);
			    }

			    $rs->getBody()->write(json_encode($col));
	}


	public function getIngredientByCategorie($req,$rs,$args)
	{
		die('here');
>>>>>>> de426c0fc65fa95c0eb75b15307199f4c0665d07
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
