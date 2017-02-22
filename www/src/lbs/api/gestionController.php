<?php

namespace lbs\api;

use lbs\common\model\Categorie;
use lbs\common\model\Ingredient;
use lbs\common\model\Commande;
use lbs\common\model\Size;
use lbs\common\model\Type;
use lbs\common\model\Sandwich;
use \Slim\Views\Twig as View;

Class gestionController extends baseController
{

	public function test( $request, $response) {

		return $this->view->render($response, 'layout.html.twig');

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

			$response = $response->withJson($newIngredient->toJson(), 201);

		} else {
			$response = $response->withJson(array('Erreur' => "erreur lors de la creation de la ressource"), 500);
		}

		return $response;
	}

}
