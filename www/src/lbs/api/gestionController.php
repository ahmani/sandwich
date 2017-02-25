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

	public function test($request, $response, $args) 
	{
		return $this->view->render($response, 'login.html.twig');
	}

    public function getRegister($request, $response, $args) 
	{
		if (!isset($_SESSION)) { session_start(); }
		if (!empty($_SESSION["register_message"]))
			return $this->view->render($response, 'register.html.twig', array("message" => $_SESSION["register_message"]));

		return $this->view->render($response, 'register.html.twig');
	}

	public function postRegister($request, $response, $args)
	{
		if (!isset($_SESSION)) { session_start(); }
		$data = $request->getParams();
		
		$user = User::where("username", "=", $data["inputUsername"])->first();
		if (!empty($user)) {

			$_SESSION["register_message"] = "Username indisponible";
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

        	unset($_SESSION["register_message"]);
        	return $response->withRedirect($this->router->pathFor('user.Login'));

        } else {

        	$_SESSION["register_message"] = "Erreur lors de votre inscription";
            return $response->withRedirect($this->router->pathFor('user.Register'));

        }

    }

	//supprimer un ingrédient dans la liste
	public function suppIngredient($request, $response, $args)
	{
		if (!isset($_SESSION)) { session_start(); }
		$body = $request->getParsedBody();

		$ingredient = Ingredient::select()->where('id', '=', $body["deletedId"])->first();

		if (!empty($ingredient))
			$ingredient->delete();	
		else
			$_SESSION["deleteIngredient_message"] = "Ingredient introuvable";

		return $response->withRedirect($this->router->pathFor('user.loadIngredients'));
	}

	//ajouter un ingredient
	public function addIngredient($request, $response, $args) 
	{
		if (!isset($_SESSION)) { session_start(); }
		if (!empty($_SESSION["addIngredient_message"]))
			$data["message"] = $_SESSION["addIngredient_message"];

		$categories = Categorie::select()->get();
		$data["categories"] = $categories;

		return $this->view->render($response, 'addIngredient.html.twig' , $data);
	}

	public function saveIngredient($request, $response, $args)
	{
		if (!isset($_SESSION)) { session_start(); }

		$ingredient = new Ingredient;
		$body = $request->getParsedBody();

		if(isset($body['inputCategorie']))
		{
			$ingredient->nom = filter_var($body['inputNom'], FILTER_SANITIZE_STRING);
			$ingredient->cat_id = filter_var($body['inputCategorie'], FILTER_SANITIZE_NUMBER_INT);

			if (isset($body["inputDescription"]) && !empty($body["inputDescription"]))
				$ingredient->description = filter_var($body['inputDescription'], FILTER_SANITIZE_STRING);

			if (isset($body["inputFournisseur"]) && !empty($body["inputFournisseur"]))
				$ingredient->fournisseur = filter_var($body['inputFournisseur'], FILTER_SANITIZE_STRING);

			/*if (isset($body["inputImage"]) && !empty($body["inputImage"]))
				$ingredient->img = filter_var($body['inputImage'], FILTER_UNSAFE_RAW);*/

			// Upload image
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["inputImage"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

			// Check if image file is a actual image or fake image
		    $check = getimagesize($_FILES["inputImage"]["tmp_name"]);
		    if($check !== false) {
		        $uploadOk = 1;
		    } else {
		        $_SESSION["addIngredient_message"] = "File is not an image.";
		        return $response->withRedirect($this->router->pathFor('user.addIngredient'));
		    }

			// Check file size
			if ($_FILES["inputImage"]["size"] > 500000)
			{
			    $_SESSION["addIngredient_message"] = "Sorry, your file is too large.";
		        return $response->withRedirect($this->router->pathFor('user.addIngredient'));
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) 
			{
				$_SESSION["addIngredient_message"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		        return $response->withRedirect($this->router->pathFor('user.addIngredient'));
			}

			// if everything is ok, try to upload file
			if (move_uploaded_file($_FILES["inputImage"]["tmp_name"], $target_file))
				$ingredient->img = filter_var(basename($_FILES["inputImage"]["name"]), FILTER_UNSAFE_RAW);
		    else
		    {
		    	$_SESSION["addIngredient_message"] = "Sorry, there was an error uploading your file.";
	        	return $response->withRedirect($this->router->pathFor('user.addIngredient'));    
		    }

			if ($ingredient->save())
				unset($_SESSION["addIngredient_message"]);
			else
				$_SESSION["addIngredient_message"] = "Erreur lors de la creation de la ressource";
			
			return $response->withRedirect($this->router->pathFor('user.addIngredient'));

		} else {
			return $response->withJson(array('Erreur' => "erreur lors de la creation de la ressource"), 500);
		}
	}

	public function getIngredients($request, $response, $args) 
	{
		if (!isset($_SESSION)) { session_start(); }
		if (!empty($_SESSION["register_message"]))
			$data["message"] = $_SESSION["deleteIngredient_message"];

		$categories = Categorie::select()->get();
		$cat_id = (!isset($_GET["categorie"]) ? 1 : $_GET["categorie"]);
		$ingredients = Ingredient::where("cat_id", "=", $cat_id)->get();
		$data["categories"] = $categories;
		$data["ingredients"] = $ingredients;
		$data["id"] = array("value" => $cat_id);


		return $this->view->render($response, 'ingredients.html.twig' , $data);
	}

	public function getSizes($request, $response, $args) 
	{
		if (!isset($_SESSION)) { session_start(); }
		if (!empty($_SESSION["register_message"]))
			$data["message"] = $_SESSION["updateSize_message"];

		$sizes = Size::select()->get();
		$data["sizes"] = $sizes;

		$size_id = (!isset($_GET["size"]) ? 1 : $_GET["size"]);
		$data["id"] = array("value" => $size_id);

		$selected_size = Size::where("id", "=", $size_id)->first();
		$data["selected_size"] = $selected_size;

		return $this->view->render($response, 'sizes.html.twig' , $data);
	}

	//modifier une taille de sandwich
	public function updateSize($request, $response, $args)
	{
		if (!isset($_SESSION)) { session_start(); }
		$body = $request->getParams();

		if (!isset($body["updatedId"])) 
		{
			$_SESSION["updateSize_message"] = "Taille introuvable";
			return $this->getSizes($request, $response, $args);
		}

		$size = Size::select()->where('id', '=', $body["updatedId"])->first();

		if (!empty($body["inputNom"]))
			$size->nom = filter_var($body['inputNom'], FILTER_SANITIZE_STRING);

		/*if (!empty($body["description"]))
			$size->description = filter_var($body['description'], FILTER_SANITIZE_STRING);*/

		if (!empty($body["inputPrix"]))
			$size->prix = filter_var($body['inputPrix'], FILTER_SANITIZE_NUMBER_FLOAT);

		if ($size->save())
			return $this->getSizes($request, $response, $args);
		else {

			$_SESSION["updateSize_message"] = "Erreur de modification";
			return $this->getSizes($request, $response, $args);
		}
	}

	//obtenir un TDB
	public function getDashboard($request, $response, $args)
	{
		try 
		{
			$today = date("Y-m-d");
			$commandes = Commande::whereDate("date", "=", $today)->get();

			$nb_commandes = 0;
			$chiffre_affaire = 0;

			foreach ($commandes as $commande)
			{
				$nb_commandes++;
				$date = date_create($commande->date)->format('Y-m-d');

				if ($today == $date)
				{
					$chiffre_affaire += $commande->montant;
				}
			}

			$data["Date"] = $today;
			$data["Nombre_commandes"] = $nb_commandes;
			$data["Chiffre_affaire"] = $chiffre_affaire;

			return $this->view->render($response, 'dashboard.html.twig' , $data);
			
			//$response = $response->withJson(json_encode($tdb), 201);

		} catch(ModelNotFoundException $e)
		{
			$response = $response->withJson(array("error" => "erreur de prise en compte"), 404);
		}

		return $response;
	}

}
