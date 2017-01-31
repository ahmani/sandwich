<?php

require_once "../vendor/autoload.php";
require_once "../src/conf/autoload.php";

use \lbs\common\model\Categorie as Categorie;
use \lbs\common\model\Commande;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;


//Pour les requetes GET et POST, il faut positionner le header : access-control-allow-origin
//Pour les requetes PUT, DELETE... il faut reponse à la requete option par un code 203 "no content"
// et positionner les hearder : access-control-allow-origin , access-control-allow-methods, access-control-allow-headers

		$capsule = new DB;

		$parse = parse_ini_file("../src/conf/connex.ini");
		$capsule->addConnection($parse);

		$capsule->setAsGlobal();
		$capsule->bootEloquent();

        $c = [
            'settings' => [
                'displayErrorDetails' => true,
            ],
        ];
        $c['notFoundHandler'] = function ($c) {
            return function ($request, $response) use ($c) {
                return $c['response']
                    ->withStatus(400)
                    ->withHeader('Content-Type', 'application/json;charset=utf8')
                    ->write(json_encode(array('Error' => 'Malformed Uri')));
            };
        };

        $c['notAllowedHandler'] = function ($c) {
            return function ($request, $response, $methods) use ($c) {
                return $c['response']
                    ->withStatus(405)
                    ->withHeader('Allow', implode(',', $methods) )
                    ->getBody()
                    ->write( 'méthode permises :' .implode(',', $methods) );
            };
        };



		/* categorie/id */
        $app = new \Slim\App(new \Slim\Container($c));

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
			function (Request $req, Response $resp, $args){
				return (new lbs\api\PublicController($this))->createCommande($req, $resp, $args);
			}
			)->setName('createCommande');

      //Créer un sandwich d'une commande existante
      $app->post('/commande/{id}/sandwich',
        function (Request $req, Response $resp, $args){
          return (new lbs\api\PublicController($this))->CreateSandwich($req, $resp, $args);
        }
        )->setName('createSandwich')
         ->add('checkToken');

			//fonction pour etat d'une commande
			$app->get('/etatcommande/{id}',
	 			function (Request $req, Response $resp, $args){
					return (new lbs\api\PublicController($this))->getEtatCommande($req,$resp,$args);
	 			}
		 	)->setName('etatCommande');

			//fonction pour obtenir une facture pour une commande livree
			$app->get('/factureCommande/{id}',
				function (Request $req, Response $resp, $args){
					return (new lbs\api\PublicController($this))->getBill($req,$resp,$args);
				}
			)->setName('factureCommande');

      // Supprimer une commande
      $app->delete('/commande/{id}',
        function (Request $req, Response $resp, $args){
            return (new lbs\api\PublicController($this))->DeleteCommande($req, $resp, $args);
        }
      )->setName('deleteCommande')
       ->add('checkToken');

    $app->run();
