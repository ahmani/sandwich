<?php

namespace lbs\api;

use lbs\common\model\Categorie;

Class PublicController 
{

	public function __contruct($this)
	{
		this->this = $this;
	}
	public function getcategorie($req,$rs,$args)
	{
		
			    $cat = Categorie::where('id', '=', $args['id'])->firstOrFail();
			    $rs = $rs->withStatus(200)
			      ->withHeader('Content-Type', 'application/json;charset=utf8');
			    $rs->getBody()->write($cat->toJson());
			  
	}
	public function getcategories($req,$rs,$args)
	{
				$app = new \Slim\App();

				$col = array();
			    $cat = Categorie::select()->get();
			    $rs = $rs->withStatus(200)
			      ->withHeader('Content-Type', 'application/json;charset=utf8');

			      var_dump($this);
			      $cats = json_decode($cat->toJson());

			      foreach ($cats as $cat) {
			      	array_push($col, ['categorie' => (array)$cat,
			      					  'links' => ['self' =>
			      					  ['href' => $app->getContainer()->get('router')->pathFor('categorie',['id' => '3'])]]]);
			      }

			      var_dump($col);die;
			    	
			    			    $rs->getBody()->write($cat->toJson());
			  
	}

	public function getIngredientByCategorie($req,$rs,$args)
	{
		die('here');
	}



}