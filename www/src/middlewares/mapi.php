<?php

use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use lbs\common\model\Commande;


function checkToken ( Request $rq, Response $rs, callable $next ) {

	$id = $rq->getAttribute('route')->getArgument( 'id');
	$token = $rq->getQueryParam('token');
		try
		 {
				Commande::where('id', '=', $id)
				->where('token', '=',$token)
				->firstOrFail();
		} 
		catch (ModelNotFoundException $e) {
			return json_error($rs,403,"no token or invalid token");

		};

return $next($rq, $rs);
};