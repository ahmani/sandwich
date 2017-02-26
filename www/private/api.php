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


        /**
        * @apiGroup Commandes
        * @apiName getCommandeDetail
        * @apiVersion 0.1.0
        *
        * @api {get} /commande/id renvoie tous les détails d'une commande
        * @apiDescription Recuperer tous les détails d'une commande
        *
        *
        * @apiSuccessExample {json} exemple de réponse en cas de succès
        *[
        *    {
        *        "Nom du client": "ikram",
        *        "Email": "ikram.ahmani@gmail.com",
        *        "Date de création": "2017-02-25 00:00:00",
        *        "Date de retrait": "2017-02-22 18:25:00",
        *        "Etat": "progress",
        *        "Sandwichs": [
        *            {
        *                "Taille": "petite faim",
        *                "Type": "blanc",
        *                "ingredients": []
        *            },
        *            {
        *                "Taille": "petite faim",
        *                "Type": "blanc",
        *                "ingredients": []
        *            },
        *            {
        *                "Taille": "petite faim",
        *                "Type": "blanc",
        *                "ingredients": []
        *            },
        *            {
        *                "Taille": "petite faim",
        *                "Type": "blanc",
        *                "ingredients": {
        *                    "salades": "laitue",
        *                    "crudités": "carottes",
        *                    "viandes": "blanc de poulet",
        *                    "Fromages": "chèvre frais"
        *                }
        *            },
        *            {
        *                "Taille": "petite faim",
        *                "Type": "blanc",
        *                "ingredients": {
        *                    "salades": "laitue",
        *                    "crudités": "carottes",
        *                    "viandes": "blanc de poulet",
        *                    "Fromages": "chèvre frais"
        *                }
        *            },
        *            {
        *                "Taille": "petite faim",
        *                "Type": "blanc",
        *                "ingredients": {
        *                    "salades": "laitue",
        *                    "crudités": "carottes",
        *                    "viandes": "blanc de poulet",
        *                    "Fromages": "chèvre frais"
        *                }
        *            },
        *            {
        *                "Taille": "petite faim",
        *                "Type": "blanc",
        *                "ingredients": {
        *                    "salades": "laitue",
        *                    "crudités": "carottes",
        *                    "viandes": "blanc de poulet",
        *                    "Fromages": "chèvre frais"
        *                }
        *            },
        *            {
        *                "Taille": "petite faim",
        *                "Type": "blanc",
        *                "ingredients": {
        *                    "salades": "laitue",
        *                    "crudités": "carottes",
        *                    "viandes": "blanc de poulet",
        *                    "Fromages": "chèvre frais",
        *                    "Sauces": "vinaigrette huile d'olive"
        *                }
        *            }
        *        ]
        *    }
        *]
        *
        * @apiError (Erreur : 404) no query results
        *
        * @apiErrorExample {json} exemple de réponse en cas d'erreur
        *     HTTP/1.1 404 Not found
        *       "Not found"
        *
        * @apiError (Erreur : 500) Missing params
        *
        * @apiErrorExample {json} exemple de réponse en cas d'erreur
        *     HTTP/1.1 500 
        *       "Id commande required"
        *
        */

        $app->get('/commande/{id}',
            function (Request $req, Response $resp, $args) {
                    return (new lbs\api\PrivateController($this))->getCommandeDetail($req,$resp,$args);
            }
        )->setName('commande');

        /**
        * @apiGroup Commandes
        * @apiName changeCommandStatus
        * @apiVersion 0.1.0
        *
        * @api {get} /commande/id Change l'état d'une commande
        * @apiDescription Change l'état d'une commande
        *
        *
        *
        * @apiSuccessExample {json} exemple de réponse en cas de succès
        * HTTP/1.1 200
        *       "Etat de la commande mis à jour"
        *
        * @apiError (Erreur : 404) no query results
        *
        * @apiErrorExample {json} exemple de réponse en cas d'erreur
        *     HTTP/1.1 404 Not Found
        *       "No query results for model [lbs\common\model\Commande."
        *
        * @apiErrorExample {json} exemple de réponse en cas d'erreur
        *     HTTP/1.1 500
        *       "Transition incorrecte"
        */

        //changement de l'etat d'une commande
        $app->put('/commandes/{id}',
        function (Request $req, Response $resp, $args) {
                return (new lbs\api\PrivateController($this))->changeCommandStatus($req,$resp,$args);
        }
        )->setName('changeCommandStatus');

    $app->run();
