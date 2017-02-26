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
    /**
    * @apiGroup backend
    * @apiName getLogin
    * @apiVersion 0.1.0
    *
    * @api {get} /login  accès à la page de connexion
    *
    * @apiDescription Accès à la page de connexion
    */
    $app->get('/login', 'gestionContoller:test')->setName('user.Login');
    $app->post('/login', 'gestionContoller:register');


    // Inscription

    /**
    * @apiGroup backend
    * @apiName getRegister
    * @apiVersion 0.1.0
    *
    * @api {get} /register accès à la page d'inscription
    *
    * @apiDescription Accès à la page d'inscription
    */
    $app->get('/register', 'gestionContoller:getRegister')->setName('user.Register');

    /**
    * @apiGroup backend
    * @apiName postRegister
    * @apiVersion 0.1.0
    *
    * @api {post} /register soumission d'une inscription
    *
    * @apiDescription soumission d'inscription
    */
    $app->post('/register', 'gestionContoller:postRegister');


    //ajouter un ingrédient

    /**
    * @apiGroup backend
    * @apiName getIngredients
    * @apiVersion 0.1.0
    *
    * @api {get} /add/ingredients accès à la page d'ajout d'ingredient
    *
    * @apiDescription Accès à la page d'ajout d'ingredient
    */
    $app->get('/add/ingredients', 'gestionContoller:addIngredient')->setName('user.addIngredient');

    /**
    * @apiGroup backend
    * @apiName postRegister
    * @apiVersion 0.1.0
    *
    * @api {post} /add/ingredients soumission d'un ingredient
    *
    * @apiDescription soumission d'un ingredient
    */
    $app->post('/add/ingredients', 'gestionContoller:saveIngredient');


    //modifier une taille de sandwich

    /**
    * @apiGroup backend
    * @apiName updateSize
    * @apiVersion 0.1.0
    *
    * @api {post} /gestion/size/id modifier une taille
    *
    * @apiDescription modifier une taille
    */
    $app->put('/gestion/size/{id}', 'gestionController:modifierTaille')->setName('modifTaille');


    //obtenir un TDB

    /**
    * @apiGroup backend
    * @apiName getIngredients
    * @apiVersion 0.1.0
    *
    * @api {get} /add/ingredients Accès au tableau de bord
    *
    * @apiDescription Accès au tableau de bord
    */
    $app->get('/gestion/tdb', 'gestionController:obtenirTDB')->setName('tableauDeBord');


    // Ingrédients par catégorie

    /**
    * @apiGroup backend
    * @apiName getIngredients
    * @apiVersion 0.1.0
    *
    * @api {get} /ingredients Accès au ingredients
    *
    * @apiDescription Accès au ingrédients
    */
    $app->get('/ingredients', 'gestionContoller:getIngredients')->setName('user.loadIngredients');


    //supprimer un ingrédient dans la liste
    /**
    * @apiGroup backend
    * @apiName deleteIngredients
    * @apiVersion 0.1.0
    *
    * @api {delete} /ingredients Accès au ingredients
    *
    * @apiDescription supprime un ingredient
    */
    $app->delete('/ingredients', 'gestionContoller:suppIngredient');


    // Charger les tailles disponibles
    /**
    * @apiGroup backend
    * @apiName getSize
    * @apiVersion 0.1.0
    *
    * @api {get} /ingredients Accès a toutes les tailles
    *
    * @apiDescription Accès a toutes les tailles
    */
    $app->get('/sizes', 'gestionContoller:getSizes')->setName('user.loadSizes');

    /**
    * @apiGroup backend
    * @apiName updateSize
    * @apiVersion 0.1.0
    *
    * @api {post} /size modifier une taille
    *
    * @apiDescription modifier une taille
    */
    $app->put('/sizes', 'gestionContoller:updateSize');


    // Tableau de bord
    /**
    * @apiGroup backend
    * @apiName updateSize
    * @apiVersion 0.1.0
    *
    * @api {get} /dashboard retourne la page du tableau de bord
    *
    * @apiDescription retourne la page du tableau de bord
    */
    $app->get('/dashboard', 'gestionContoller:getDashboard')->setName('user.loadDashboard');


    $app->run();
