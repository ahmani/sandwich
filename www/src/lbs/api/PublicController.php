<?php

namespace lbs\api;

use lbs\common\model\Categorie;
use lbs\common\model\Ingredient;
use lbs\common\model\Commande;
use lbs\common\model\size;
use lbs\common\model\type;
use lbs\common\model\sandwich;

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
	public function getingredient($req,$rs,$args){
		try{
			$ing = Ingredient::where('id', '=', $args['id'])->firstOrFail();
			$rs = $rs->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf8');
				$rs->getBody()->write($ing->toJson());
		}catch(\Exception $e){
			$rs = $rs->withStatus(404)
			->withHeader('Content-Type', 'application/json;charset=utf8');
			$rs->getBody()->write(json_encode(array('Erreur' => $e->getMessage())));
			return $rs;
		}
	}


	/* fonction pour collection d'ingredients pour 1 categorie */
	public function getIngredientsByCategory($req,$rs,$args)
	{
		$ings = Ingredient::where('cat_id','=',$args['cat_id'])->get();
		if(!$ings->isEmpty()){
			$rs = $rs->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf8');
			$col = array();
			$ingredients = json_decode($ings->toJson());
			if (!empty($ingredients))
			{
				foreach ($ingredients as $ings)
				{
					array_push($col, ['ingredient' => (array)$ings,
					'links' => ['self' =>
					['href' => $this->cont['router']->pathFor('ingredient',['id' => $ings->id])]]]);
				}
			}
				$rs->getBody()->write(json_encode($col));
		}else{
				$rs = $rs->withStatus(404)
				->withHeader('Content-Type', 'application/json;charset=utf8');
				$rs->getBody()->write(json_encode(array('Erreur' => 'not found')));
				return $rs;
		}
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
			$rs = $rs->withStatus(404)
			->withHeader('Content-Type', 'application/json;charset=utf8');
			$rs->getBody()->write(json_encode(array('Erreur' => $e->getMessage())));
			return $rs;
		}
	}


	/* fonction pour creer une commande */
	public function createCommande($req, $rs, $args){
		$com = new Commande;
		//Creation du token
		$factory = new \RandomLib\Factory;
		$generator = $factory->getMediumStrengthGenerator();
		$com->token = $generator->generateInt(32);

		var_dump($req->getParsedBody());
		$com->nom_client = filter_var($req->getParsedBody()['nom_client'], FILTER_SANITIZE_STRING);
		$com->email = filter_var($req->getParsedBody()['email'], FILTER_SANITIZE_EMAIL);
		$com->date = date("j-n-Y");
		$com->montant = filter_var($req->getParsedBody()['montant'], FILTER_SANITIZE_NUMBER_INT);
		$com->save();

	}


	//fonction pour créer un sandwich d'une commande existante
	public function CreateSandwich($req, $rs,$args)
	{
		$count = 0;

		//$commande = Commande::where('id', '=', $args['id'])->firstOrFail();

		$body = $req->getParsedBody();

			if(!empty($body['taille']))
				$size = size::where('id', '=', $body['taille'])->firstOrFail();
			else
				json_error($rs,500,"Size required");



		foreach ($body['ingredient'] as $key => $value) {
					$categorie = categorie::where('id', '=', $key)->firstOrFail();
					if($categorie->special == '1')
					{

						$count= $count+1;
					}
		}

		if($body['token'] == $commande->token && $commande->etat == "created")
		{
			if($size->nb_ingredients == count($body['ingredient']) && $count <= $size->nb_special)
			{
				$sandwich = new sandwich;
				$sandwich->id_size = $body['taille'];
				$sandwich->id_type = $body['type'];
				$sandwich->save();

				foreach ($body['ingredient'] as $key => $value) {

					$ingredient = ingredient::where('id', '=', $value)->firstOrFail();
					$sandwich->ingredients()->save($ingredient);
				}

			}
			return  json_error($rs,500,"error");
		}


		//passer le token par ul
		//tester la correspondance entre le token et id_commande
		//test sur l'état de la commande
		// test sur les ingrédients du sandwich
		// Ajouter le sandwich


	}

	//fonction pour etat d'une commande
	public function getEtatCommande($req, $rs,$args){
		$etat = Commande::where('id', '=', $args['id'])->get();
		if(!$etat->isEmpty()){
			$rs = $rs->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf8');
			$rs->getBody()->write($etat->toJson());



			/*array_push($etat, ['commande' => (array)$etat,
				'links' => ['self' =>
				['href' => $this->cont['router']->pathFor('commande',['id' => $etat->id])]]]);

			$rs->getBody()->write(json_encode($etat));*/
		}else{
			$rs = $rs->withStatus(404)
			->withHeader('Content-Type', 'application/json;charset=utf8');
			$rs->getBody()->write(json_encode(array('Erreur' => 'not found')));
			return $rs;
		}
	}
}
