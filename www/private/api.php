<?php

require_once "../vendor/autoload.php";
require_once "../src/conf/autoload.php";
require_once "../src/lbs/utils/CommonsFunctions.php";

//define("COMMANDE_CREATED", "created");

use \lbs\common\model\Categorie as Categorie;
use \lbs\common\model\Commande;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;

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
        $app->add('addheaders');

        $app->get('/commandes',
            function (Request $req, Response $resp, $args) {
                if(empty($req->getQueryParams()))
             		    return (new lbs\api\PrivateController($this))->getcommandes($req,$resp,$args);

                elseif (isset($req->getQueryParams()['etat']) || isset($req->getQueryParams()['date_livraison'])) {
                    return (new lbs\api\PrivateController($this))->getFiltredCommandes($req,$resp,$args);

                }elseif (isset($req->getQueryParams()['offset']) && isset($req->getQueryParams()['limit'])){
                    return (new lbs\api\PrivateController($this))->getPaginatedCommandes($req,$resp,$args);
                }
            }
        )->setName('commandes');

        $app->get('/commande/{id}',
            function (Request $req, Response $resp, $args) {
                    return (new lbs\api\PrivateController($this))->getCommandeDetail($req,$resp,$args);
            }
        )->setName('commande');

        //changement de l'etat d'une commande
        $app->get('/commande/{id}/changerEtatCom',
            function (Request $req, Response $resp, $args) {
                    return (new lbs\api\PrivateController($this))->changerEtatCom($req,$resp,$args);
            }
        )->setName('changerEtatCom');


    $app->run();
