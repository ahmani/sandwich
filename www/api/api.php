<?php

require_once "../vendor/autoload.php";
require_once "../src/conf/autoload.php";

use \lbs\common\model\Categorie as Categorie;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;


//use lbs\utils\ConnectionFactory as Con;

//require_once "../src/lbs/utils/ConnectionFactory.php";


		$capsule = new DB;

		$parse = parse_ini_file("../src/conf/connex.ini");
		$capsule->addConnection($parse);

		$capsule->setAsGlobal();
		$capsule->bootEloquent();




    $app = new \Slim\App;
    $app->get('/categorie/{id}',
     function (Request $req, Response $resp, $args) {
     		return (new lbs\api\PublicController($this))->getcategorie($req,$resp,$args);
     }
    );
    $app->get('/categories',
     function (Request $req, Response $resp, $args) {
     		return (new lbs\api\PublicController($this))->getcategories($req,$resp,$args);
     }
    );


		$app->get('/ingredient/{id}',
			function (Request $req, Response $resp, $args){
				return (new lbs\api\PublicController($this))->getingredient($req,$resp,$args);
			}
		);


    $app->run();
