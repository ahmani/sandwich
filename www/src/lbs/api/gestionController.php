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

}
