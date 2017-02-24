<?php

namespace lbs\api;

use lbs\common\model\User;
use lbs\common\model\Size;
use lbs\common\model\Commande;
use lbs\common\model\Categorie;
use lbs\common\model\Ingredient;

use \Slim\Views\Twig as View;

Class gestionController extends baseController 
{

	public function test($request, $response) 
	{
		return $this->view->render($response, 'login.html.twig');
	}

    public function getRegister($request, $response) 
	{
		if (!isset($_SESSION)) { session_start(); }
		if (!empty($_SESSION["message"]))
			return $this->view->render($response, 'register.html.twig', array("message" => $_SESSION["message"]));

		return $this->view->render($response, 'register.html.twig');
	}

	public function postRegister($request, $response)
	{
		$data = $request->getParams();
		if (!isset($_SESSION)) { session_start(); }

		$user = User::where("username", "=", $data["inputUsername"])->first();
		if (!empty($user)) {

			$_SESSION["message"] = "Username indisponible";
			return $response->withRedirect($this->router->pathFor('user.Register'));

		}

        $user = new User();
        $user->last_name = filter_var($data['inputPrenom'], FILTER_SANITIZE_STRING);
        $user->first_name = filter_var($data['inputNom'], FILTER_SANITIZE_STRING);
        $user->username = filter_var($data['inputUsername'], FILTER_SANITIZE_STRING);
        $pass = filter_var($data['password'], FILTER_SANITIZE_STRING);
        $user->password = password_hash($pass, PASSWORD_DEFAULT);

        if($user->save())
        {

        	unset($_SESSION["message"]);
        	return $response->withRedirect($this->router->pathFor('user.Login'));

        } else {

        	$_SESSION["message"] = "Erreur lors de votre inscription";
            return $response->withRedirect($this->router->pathFor('user.Register'));

        }

    }

	//supprimer un ingrédient dans la liste
	public function suppIngredient($request, $response, $args){
		try {

			$ingredient = Ingredient::select()->where('id','=',$args['id'])->first();
			if (!empty($ingredient)) {
				$ingredient->delete();
				$response = $response->withJson(array('Succes' => "deleted"), 201);
			} 

			$response = $response->withJson(array('Erreur' => "Not found"), 404);

		} catch(ModelNotFoundException $e){

			$response = $response->withJson(array('Erreur' => "Not found"), 404);

		}

		return $response;
	}

	//ajouter un ingredient
	public function ajouterIngredient($request, $response, $args)
	{
		$ingredient = new Ingredient;
		$body = $request->getParsedBody();

		if(isset($body['cat_id']))
		{
			$ingredient->nom = filter_var($body['nom'], FILTER_SANITIZE_STRING);
			$ingredient->cat_id = filter_var($body['cat_id'], FILTER_SANITIZE_NUMBER_INT);
			$ingredient->description = filter_var($body['description'], FILTER_SANITIZE_STRING);
			$ingredient->fournisseur = filter_var($body['fournisseur'], FILTER_SANITIZE_STRING);
			$ingredient->img = filter_var($body['img'], FILTER_UNSAFE_RAW);
			$ingredient->save();

			$newIngredient = array($ingredient, $ingredient->categorie);
			var_dump($newIngredient);die;

			$response = $response->withJson($newIngredient->toJson(), 201);

		} else {
			$response = $response->withJson(array('Erreur' => "erreur lors de la creation de la ressource"), 500);
		}

		return $response;
	}

	//modifier une taille de sandwich
	public function modifierTaille($request, $response, $args)
	{
		try
		{
			if (!isset($args["id"]))
				return $response->withJson(array('Erreur' => "Missing param"), 500);

			$data = $request->getParsedBody();

			$size = Size::select()->where('id','=',$args['id'])->firstOrFail();

			if (!empty($data["nom"]))
				$size->nom = filter_var($data['nom'], FILTER_SANITIZE_STRING);

			if (!empty($data["description"]))
				$size->description = filter_var($data['description'], FILTER_SANITIZE_STRING);

			if (!empty($data["prix"]))
				$size->prix = filter_var($data['prix'], FILTER_SANITIZE_NUMBER_FLOAT);

			$size->save();
			$response = $response->withJson(json_encode($size), 201);

		} catch(ModelNotFoundException $e)
		{
			$response = $response->withJson(array("error" => "Not found"), 404);
		}

		return $response;
	}


	//obtenir un TDB
	public function obtenirTDB($request, $response, $args)
	{
		try 
		{
			$commandes = Commande::select()->get();

			$nb_commandes = 0;
			$chiffre_affaire = 0;

			foreach ($commandes as $commande)
			{
				$nb_commandes++;
				$today = date("Y-m-d");
				$date = date_create($commande->date)->format('Y-m-d');

				if ($today == $date)
				{
					$chiffre_affaire += $commande->montant;
				}
			}

			$tdb = array("Nombre de commandes : " => $nb_commandes , "Chiffre d'affaire" => $chiffre_affaire);
			$response = $response->withJson(json_encode($tdb), 201);

		} catch(ModelNotFoundException $e)
		{
			$response = $response->withJson(array("error" => "erreur de prise en compte"), 404);
		}

		return $response;
	}

	public function getIngredients($request, $response) 
	{
		$categories = Categorie::select()->get();
		$cat_id = (!isset($_GET["categorie"]) ? 1 : $_GET["categorie"]);
		$ingredients = Ingredient::where("cat_id", "=", $cat_id)->get();
		$data["categories"] = $categories;
		$data["ingredients"] = $ingredients;
		$data["id"] = array("value" => $cat_id);

		return $this->view->render($response, 'ingredients.html.twig' , $data);

	}
}
