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
	public function suppIngredient(Request $request, Response $response, $args){
		try{
			$ingredient = Ingredient::select()->where('id','=',$args['id'])->firstOrFail();
			$ingredient->delete();
			$response = $this->json_success($response, 201, "deletion done");
		}catch(ModelNotFoundException $e){
			$response = $response>withStatus(404)->withHeader('Content-type', 'application/json');
			$errorMessage = ["error" => "id not found" ];
			$response->getBody()->write(json_encode($errorMessage));
		}
		return $response;
	}


	//ajouter un ingredient
	public function ajouterIngredient(Request $request, Response $response, $args){
		$ingredient = new Ingredient;
		if(isset($request->getParsedBody()['cat_id'])){
				 $ingredient->nom = filter_var($request->getParsedBody()['nom'], FILTER_SANITIZE_STRING);
				 $ingredient->cat_id = filter_var($request->getParsedBody()['cat_id'], FILTER_SANITIZE_INT);
				 $ingredient->description = filter_var($request->getParsedBody()['description'], FILTER_SANITIZE_STRING);
				 $ingredient->fournisseur = filter_var($request->getParsedBody()['fournisseur'], FILTER_SANITIZE_STRING);
				 $ingredient->img = filter_var($request->getParsedBody()['img'], FILTER_SANITIZE_STRING);
				 $ingredient->save();

				 $newIngredient = array($ingredient, $ingredient->getingredientcat());
				 $response = $this->json_success($response, 201, $newIngredient->toJson());
		}else{
			 $response = $this->json_error($response, 500, "erreur lors de la creation de la ressource");
		}
		return $response;
	}


	//modifier une taille de sandwich
	public function modifierTaille(Request $request, Response $response, $args){
		try{
			$size = Size::select()->where('id','=',$args['id'])->firstOrFail();
			$size->nom = filter_var($request->getParsedBody()['nom'], FILTER_SANITIZE_STRING);
			$size->description = filter_var($request->getParsedBody()['description'], FILTER_SANITIZE_STRING);
			$size->prix = filter_var($request->getParsedBody()['prix'], FILTER_SANITIZE_FLOAT);
			$size->save();
			$response = $this->json_success($response, 201, $size->toJson());
		}catch(ModelNotFoundException $e){
				$response = $response->withStatus(404)->withHeader('Content-type', 'application/json');
				$errorMessage = ["error" => "id not found" ];
				$response->getBody()->write(json_encode($errorMessage));
		}
			return $response;
	}


}
