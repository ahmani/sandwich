<?php

namespace lbs\api;

use lbs\common\model\Categorie;
use lbs\common\model\Ingredient;
use lbs\common\model\Commande;

Class PublicController
{

	private $cont;

	public function __construct($var)
	{
		$this->cont= $var;
	}


	/* fonction pour categorie/id */
	public function getcategorie($req,$rs,$args)
	{
		try{
		$cat = Categorie::where('id', '=', $args['id'])->firstOrFail();
			$rs = $rs->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf8');
			$rs->getBody()->write($cat->toJson());
			return $rs;
		
		}catch(\Exception $e){
			$rs = $rs->withStatus(404)
			->withHeader('Content-Type', 'application/json;charset=utf8');
			$rs->getBody()->write(json_encode(array('Erreur' => $e->getMessage())));
			return $rs;
		}
	}


	/* fonction pour collection de categories */
	public function getcategories($req,$rs,$args)
	{
		$cat = Categorie::select()->get();
		$rs = $rs->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf8');
		$col = array();
		$cats = json_decode($cat->toJson());

		foreach ($cats as $cat)
		{
			array_push($col, ['categorie' => (array)$cat,
			  'links' => ['self' =>
			  ['href' => $this->cont['router']->pathFor('categorie',['id' => $cat->id])]]]);
		}
		$rs->getBody()->write(json_encode($col));
	}


	/* fonction pour ressource ingredient/id*/
	public function getingredient($req,$rs,$args)
	{
		$ing = Ingredient::where('id', '=', $args['id'])->firstOrFail();
		$rs = $rs->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf8');
		$rs->getBody()->write($ing->toJson());
	}


	/* fonction pour collection d'ingredients pour 1 categorie */
	public function getIngredientsByCategory($req,$rs,$args)
	{
		$ings = Ingredient::where('cat_id','=',$args['cat_id'])->get();
		$rs = $rs->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf8');
		$rs->getBody()->write($ings->toJson());
	}


	/* fonction pour categorie d'un ingredient */
	public function getingredientcat($req,$rs,$args)
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


	/* fonction pour creer une commande */
	public function createCommande($req, $rs, $args){

	}


	//fonction pour créer un sandwich d'une commande existante
	public function CreateSandwich($req, $rs,$args)
	{
		$commande = Commande::where('id', '=', $args['id'])->firstOrFail();
		if($_POST['token'] == $commande->token && $commande->etat == "created")
		{

		}
		//passer le token par ul
		//tester la correspondance entre le token et id_commande
		//test sur l'état de la commande
		// test sur les ingrédients du sandwich
		// Ajouter le sandwich

	}
}
