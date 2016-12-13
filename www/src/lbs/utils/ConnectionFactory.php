<?php

namespace lbs\utils;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;

class ConnectionFactory{
	static private $config,$db;
	
	public static function setConfig($nom_fichier)
	{
		$parse = parse_ini_file($nom_fichier);	
		self::$config = $parse;
	}

	public static function makeConnection()
	{
		$capsule = new DB;		

		$capsule->addConnection(self::$config);

		$capsule->setAsGlobal();
		$capsule->bootEloquent();


		return $capsule;
	}
	
	

}
