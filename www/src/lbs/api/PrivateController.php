<?php

namespace lbs\privates\api;

use lbs\common\model\Categorie;
use lbs\common\model\Ingredient;
use lbs\common\model\Commande;
use lbs\common\model\size;
use lbs\common\model\type;
use lbs\common\model\sandwich;

Class PrivateController
{

	private $cont;

	public function __construct($var)
	{
		$this->cont= $var;
	}

	public function getcommandes($req,$rs,$args)
	{
		die('ddd');
	}



}
