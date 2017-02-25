<?php

require_once "../vendor/autoload.php";
require_once "../src/conf/autoload.php";
require_once "../src/lbs/utils/CommonsFunctions.php";
require_once "../src/lbs/utils/gestion_erreurs.php";


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


    $container = $app->getContainer();

    $container["view"] = function($container) {

        $view = new \Slim\Views\Twig(__DIR__ . '/views', [
            'chache' => false,
        ]);


        $view->addExtension(new \Slim\Views\TwigExtension(

            $container->router,

            $container->request->getUri()
        ));

        return $view;
    };

    $container["gestionContoller"] = function($container) {

        return new \lbs\api\gestionController($container);

    };


    // Routes

    // Authentification
    $app->get('/login', 'gestionContoller:test')->setName('user.Login');

    $app->post('/login', 'gestionContoller:register');

    // Inscription
    $app->get('/register', 'gestionContoller:getRegister')->setName('user.Register');

    $app->post('/register', 'gestionContoller:postRegister');

    //ajouter un ingrédient
    $app->get('/add/ingredients', 'gestionContoller:addIngredient')->setName('user.addIngredient');
    $app->post('/add/ingredients', 'gestionContoller:saveIngredient');

    //modifier une taille de sandwich
    $app->put('/gestion/size/{id}',
        function (Request $req, Response $resp, $args) {
                return (new lbs\api\gestionController($this))->modifierTaille($req,$resp,$args);
        }
    )->setName('modifTaille');

    //obtenir un TDB
    $app->get('/gestion/tdb',
        function (Request $req, Response $resp, $args) {
                return (new lbs\api\gestionController($this))->obtenirTDB($req,$resp,$args);
        }
    )->setName('tableauDeBord');

    // Ingrédients par catégorie
    $app->get('/ingredients', 'gestionContoller:getIngredients')->setName('user.loadIngredients');

    //supprimer un ingrédient dans la liste
    $app->delete('/ingredients', 'gestionContoller:suppIngredient');

    $app->run();
