<?php

require_once "../vendor/autoload.php";
require_once "../src/conf/autoload.php";
require_once "../src/lbs/utils/CommonsFunctions.php";


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


    /*$app->get('/categories',
        function (Request $req, Response $resp) {
            return $this->view->render($resp, 'layout.html.twig');
        }
    );*/

    $app->get('/categories', 'gestionContoller:test');

    $app->run();
