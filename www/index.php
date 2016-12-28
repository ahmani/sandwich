<?php

require_once "vendor/autoload.php";
require_once "src/conf/autoload.php";

use lbs\common\model\Categorie as Category;
use lbs\utils\ConnectionFactory as Con;

Con::setConfig("src/conf/connex.ini");
Con::makeConnection();
if(isset($_GET['id']))
{
	$cat = Category::find($_GET['id'])->get();
}else{
	$count = Category::count();
	$cat = Category::select('id','nom')->get();
}

header('Content-type : application/json');
//echo json_encode(array('nbr' => $count , 'categories' => $cat->toArray()));

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
  $desc = filter_Var($_POST['description'], FILTER_SANITIZE_STRING);

  $cat = new Category();
  $cat->nom = $nom;
  $cat->description = $desc;
  $cat->save();

  http_response_code(201);
  header('Content-Type: application/json');
  echo json_encode($cat->toArray());

  exit;
}
