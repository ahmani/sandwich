<?php

namespace lbs\api;

use lbs\common\model\Categorie;
use lbs\common\model\Ingredient;
use lbs\common\model\Commande;
use lbs\common\model\size;
use lbs\common\model\type;
use lbs\common\model\Sandwich;
use lbs\common\model\Card;
use lbs\common\utils\CommonsFunctions;


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
			return json_error($rs, 404, $e->getMessage());
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
			return json_error($rs, 404, $e->getMessage());
		}
	}


	/* fonction pour collection d'ingredients pour 1 categorie ingredients/cat_id*/
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
			return json_error($rs, 404, 'Not found');
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
			return json_error($rs, 404, $e->getMessage());
		}
	}


	/* fonction pour creer une commande */
	public function createCommande($req, $rs, $args){
		$com = new Commande;
		//Creation du token
		$factory = new \RandomLib\Factory;
    $generator = $factory->getMediumStrengthGenerator();

	if(isset($req->getParsedBody()['nom_client']) &&
		 isset($req->getParsedBody()['email']) &&
		 isset($req->getParsedBody()['date_retrait']) &&
		 isset($req->getParsedBody()['date'])){
			$com->token = $generator->generateString(32, 'abcdefghijklmnopqrstuvwxyz123456789');
			$com->nom_client = filter_var($req->getParsedBody()['nom_client'], FILTER_SANITIZE_STRING);
			$com->email = filter_var($req->getParsedBody()['email'], FILTER_SANITIZE_EMAIL);
			$com->date = date("Y-n-j");
			$com->date_retrait = filter_var($req->getParsedBody()['date_retrait'], FILTER_SANITIZE_STRING);
			$com->montant = 0;


			$com->save();
			$rs = $rs->withJson($com, 201);
			$rs->withHeader('Location', '/commandes//'+$com->id);
			return $rs;
	}else{
		json_error($rs, 400, "fill all the fields");
		}
	}



	/*
	* fonction pour créer un sandwich d'une commande existante
	*
	* Author : ikram
	*/
	public function CreateSandwich($req, $rs,$args)
	{
		$count = 0;

		if($args['id'])
			{
				$commande = Commande::where('id', '=', $args['id'])->firstOrFail();
			}
		else
			{
				return json_error($rs,500,"Id commande required");
			}

		$body = $req->getParsedBody();

		if(!empty($body['taille']))
			{
				$size = size::where('id', '=', $body['taille'])->firstOrFail();
			}
		else
			{
				json_error($rs,500,"Size required");
			}
		if(!empty($body['ingredient']))
		{
			foreach ($body['ingredient'] as $value) {
			$ingredient = ingredient::where('id','=', $value )->firstOrFail();
			$categorie = categorie::where('id', '=', $ingredient->cat_id)->firstOrFail();
			if($categorie->special == '1')
				$count= $count+1;
			}
		}
		else
		{
			return  json_error($rs,500,"Ingredients required");
		}

		if($commande->etat == "created")
		{
			if(!empty($body['ingredient']))
			{
				if($size->nb_ingredients == count($body['ingredient']))
				{
					if($count <= $size->nb_special)
					{
						$sandwich = new sandwich;
						$sandwich->id_size = $body['taille'];
						$sandwich->id_type = $body['type'];
						$sandwich->id_commande  = $args['id'];
						$sandwich->save();

						foreach ($body['ingredient'] as $value) {
							$ingredient = ingredient::where('id', '=', $value)->firstOrFail();
							$sandwich->ingredients()->save($ingredient);
							$cat = categorie::where('id', '=', $ingredient->cat_id)->firstOrFail();
							$array[$cat->nom] = $ingredient->nom;
						}

						$commande->montant += $sandwich->size->prix;
						$commande->save();

				        $response = array('Taille' => size::where('id', '=', $sandwich->id_size)->firstOrFail()->nom,
				        				  'Type' => Type::where('id', '=', $sandwich->id_type)->firstOrFail()->nom,
				        				  'ingredients' => $array);
				        $rs = $rs->withJson($response, 201);
						return $rs;

					}else{
						return  json_error($rs,500,"Nombre d'ingredients speciale incorrecte");
					}


				}else
				{
					return  json_error($rs,500,"Nombre d'ingredients incorrecte");
				}
			}
			else
			{
				return  json_error($rs,500,"Ingredient required");
			}

		}

	}
	/*
	* fonction pour supprimer une commande
	*
	* Author : ikram
	*/
	public function DeleteCommande($req, $rs,$args)

	{

		$commande = Commande::where('id', '=', $args['id'])->firstOrFail();
		if($commande->etat == "created")
		{
			$commande->delete();
			return json_success($rs,200, 'La commande a été supprimée avec succes');
		}else
		{
			return  json_error($rs,500,"La commande est déja payée");
		}

	}

	//fonction pour etat d'une commande etatcommande/id
	public function getEtatCommande($req, $rs,$args){
		try{
			$etat = Commande::where('id', '=', $args['id'])->firstOrFail();
			if(!empty($etat)){
				$rs = $rs->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf8');
				//$rs->getBody()->write($etat->toJson());
				$etatcommande = array();
				$commandes = array("id"=>$etat->id , "token"=>$etat->token,"etat"=>$etat->etat,
				"nom_client"=>$etat->nom_client,"email"=>$etat->email,"date"=>$etat->date, "date_retrait"=>$etat->date_retrait, "montant"=>$etat->montant);
				array_push($etatcommande, ['commande' => $commandes,
				'links' => ['self' =>
				['href' => $this->cont['router']->pathFor('etatCommande',['id' => $etat->id])]]]);

				$rs->getBody()->write(json_encode($etatcommande));
			}
		}catch(\Exception $e){
			return json_error($rs,404,$e->getMessage());
		}
	}

	// Fonction pour supprimer un sandwich d'une commande
	// author : Chakib
	public function deleteSandwich($req, $rs, $args)
	{
		$commande = Commande::where("id", "=", $args["id"])->firstOrFail();
		$sandwichs = $commande->sandwichs;

		foreach ($sandwichs as $sandwich) {
			if ($sandwich->id == $args["id_sandwich"])
			{
				$commande->montant = $commande->montant - $sandwich->size->prix;
				$commande->save();
				$sandwich->delete();
				return $rs->withStatus(200);
			}
		}

		return  json_error($rs, 500, "Le sandwich n'existe pas");
	}


	// fonction  pour obtenir une facture pour une commande livree factureCommande/id
	public function getBill($req, $rs, $args){
		$commande = Commande::where("id", "=", $args["id"])->firstOrFail();
		if(($commande->etat == "delivered") && (!empty($commande))){
			$montant = $commande->montant;
			$facture = array(GetSandwichsByCommande($commande->id), "montant de la commande"=>$montant);
			$rs->getBody()->write(json_encode($facture));
		}else{
				return json_error($rs,400	 ,'la commande n\'est pas encore livree');
		}
	}

	public function payCommande($req, $rs, $args){
		$commande = Commande::where('id', '=', $args['id'])->firstOrFail();
		if(isset($req->getParsedBody()['nom']) &&
			isset($req->getParsedBody()['prenom']) &&
			isset($req->getParsedBody()['numCarte']) &&
			isset($req->getParsedBody()['montant']) &&
			isset($req->getParsedBody()['cryptogramme'])) {

				if($req->getParsedBody()['montant'] != $commande->montant){
		 			return json_error($rs, 400, 'les montants ne correspondent pas');
		 		}

				$commande->etat = "paid";
				$commande->save();
				return json_success($rs, 200, 'commande mise à jour');
		} else{
			return json_error($rs, 500, 'un problème est survenu');
		}
	}

	// Modifier un sandwich d'une commande existante
	public function updateSandwich($req, $rs, $args)
	{
		$count = 0;

		if($args['id'])
		{
			$commande = Commande::where('id', '=', $args['id'])->firstOrFail();
		} else {
			return json_error($rs, 500, "Id commande required");
		}

		$body = $req->getParsedBody();

		if(empty($body['taille']))
		{
			json_error($rs, 500, "Size required");
		}

		if(!empty($body['ingredient']))
		{
			foreach ($body['ingredient'] as $value)
			{
				$ingredient = Ingredient::where("id", "=", $value)->firstOrFail();
				$categorie = categorie::where('id', '=', $ingredient->cat_id)->firstOrFail();

				if($categorie->special == '1')
					$count = $count + 1;
			}
		} else {
			return  json_error($rs, 500, "Ingredients required");
		}

		$sandwich = sandwich::where("id", "=", $args["id_sandwich"])->firstOrFail();

		if ($commande->etat == "created")
		{
			if ($sandwich->id_size != $body["taille"])
			{
				$old_size = $sandwich->id_size;
				$sandwich->id_size = $body["taille"];
			}

			if ($sandwich->id_type != $body["type"])
			{
				$sandwich->id_type = $body["type"];
			}

			$taille = size::where("id", "=", $body["taille"])->firstOrFail();

			if ($taille->nb_ingredients == count($body["ingredient"]))
			{
				if($count <= $taille->nb_special)
				{
					foreach ($body["ingredient"] as $key => $value)
					{
						if ($key != $value)
						{
							$sandwich->ingredients()
							    	->newPivotStatement()
							    	->where('id_sandwich', $args["id_sandwich"])
							    	->where('id_ingredient', $key)
							    	->update(array('id_ingredient' => $value));
						}
					}

					$sandwich->save();
					$commande->save();

				} else {
					return  json_error($rs, 500, "Erreur nombre ingredients");
				}
			} else {

			}

		} else if ($commande->etat == "paid") {
			foreach ($body["ingredient"] as $key => $value)
			{
				if ($key != $value)
				{
					$ingredient = ingredient::where("id", "=", $key)->firstOrFail();

					if ($ingredient->cat_id == 5) {
						$sandwich->ingredients()
					    	->newPivotStatement()
					    	->where('id_sandwich', $args["id_sandwich"])
					    	->where('id_ingredient', $key)
					    	->update(array('id_ingredient' => $value));
					}
				}
			}

			$sandwich->save();
			$commande->save();
		}
	}

	//fonction pour modifier la date de livraison d'une commande
	public function updateCommande($req, $rs,$args)
	{
		try {
			$body = $req->getParsedBody();
			$commande = Commande::where('id', '=', $args['id'])->firstOrFail();

			if($commande->etat != "livrée") {
				$commande->date_retrait = $body["date_retrait"];
				$commande->save();
				return json_success($rs, 200, "commande mise à jour");
			}

		}catch(\Exception $e){
			return json_error($rs, 404, $e->getMessage());
		}
	}

	//fonction pour modifier la date de livraison d'une commande
	public function getCommandeDescription($req, $rs,$args)
	{
		try {
			$body = $req->getParsedBody();
			$commande = Commande::where('id', '=', $args['id'])->firstOrFail();

			$sandwichs = $commande->sandwichs;
			$array = json_encode($commande);
			$rs = $rs->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf8');
				$rs->getBody()->write($commande->toJson());
			// foreach ($sandwichs as $sandwich) {
			// 	$array[$sandwich->id] = $sandwich->size->prix;
			// }

			return $rs;

		}catch(\Exception $e){
			return json_error($rs, 404, $e->getMessage());
		}
	}

	public function createFidelityCard($request, $response, $args)
	{
		if (!isset($args["id"]))
			return json_error($rs, 500, "Missing Id");

		$card = Card::where("id_user", "=", $args["id"])->first();

		if (!empty($card))
			return json_error($response, 401, "Vous avez deja une carte de fidelite");

		$newCard = new Card();
		$newCard->id_user = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$newCard->credit = 0;
		$newCard->save();

		return json_success($response, 201, $newCard->id);
		
	}
}
