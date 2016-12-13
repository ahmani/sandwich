<?php

namespace lbs\api;

use lbs\common\model\Categorie;

Class PublicController 
{

	public function getcategorie($req,$rs,$args)
	{
		
			    $cat = Categorie::where('id', '=', $args['id'])->firstOrFail();
			    $rs = $rs->withStatus(200)
			      ->withHeader('Content-Type', 'application/json;charset=utf8');
			    $rs->getBody()->write($cat->toJson());
			  
	}
	public function getcategories($req,$rs,$args)
	{
		
			    $cat = Categorie::select()->get();
			    $rs = $rs->withStatus(200)
			      ->withHeader('Content-Type', 'application/json;charset=utf8');
			    $rs->getBody()->write($cat->toJson());
			  
	}



}