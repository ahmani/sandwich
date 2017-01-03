<?php

require_once "../vendor/autoload.php";
require_once "../src/conf/autoload.php";

use \lbs\common\model\Categorie as Categorie;
use \lbs\common\model\Commande;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;


//TODO

//creation de commande ; information de la personne(nom, email) , date_commande, livraison(date, heure)... ajout dans le hearder location 'commande/id'
// réponse {"commande": {"nom"=>"michel","token" = > "https://github.com/ircmaxell/RandomLib".....}}

//creation d'un token qui identifie la commande, passage du token pour chaque opération sur un commande, test du token avant chaque opération

//Ajout des sandwichs

//Gestion des erreurs :
// 500,404,400, 201 created

		$capsule = new DB;

		$parse = parse_ini_file("../src/conf/connex.ini");
		$capsule->addConnection($parse);

		$capsule->setAsGlobal();
		$capsule->bootEloquent();

		/* categorie/id */
    $app = new \Slim\App;
    $app->get('/categorie/{id}',
     function (Request $req, Response $resp, $args) {
     		return (new lbs\api\PublicController($this))->getcategorie($req,$resp,$args);
     }
    )->setName('categorie');

		/* collection de categories */
    $app->get('/categories',
     function (Request $req, Response $resp, $args) {
     		return (new lbs\api\PublicController($this))->getcategories($req,$resp,$args);
     }
    )->setName('categories');

		/*ressource ingredient/id*/
		$app->get('/ingredient/{id}',
			function (Request $req, Response $resp, $args){
				return (new lbs\api\PublicController($this))->getingredient($req,$resp,$args);
			}
		)->setName('ingredient');

		/* collection d'ingredients pour 1 categorie */
    $app->get('/ingredients/{cat_id}',
     function (Request $req, Response $resp, $args) {
            return (new lbs\api\PublicController($this))->getIngredientsByCategory($req,$resp,$args);
     }
    )->setName('ingredientsByCat');

		/* categorie d'un ingredient */
		$app->get('/ingredientcat/{id}',
			function (Request $req, Response $resp, $args){
				return (new lbs\api\PublicController($this))->getingredientcat($req,$resp,$args);
			}
		)->setName('IngredientCat');

		/* creer une commande */
		$app->post('/commandes',
			function (Request $req, Respong $resp, $args){
				return (new lbs\api\PublicController($this))->createCommande($req, $resp, $args);
			}
			)->setName('createCommande');

    $app->run();
