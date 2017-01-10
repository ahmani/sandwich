<?php

namespace lbs\common\model;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;



Class Commande extends Model{
  /*protected $token;
  protected $state; //{'created' ; 'paid' ; 'progress' ; 'ready' ; 'delivered'}
  protected $nom;
  protected $email;
  protected $sandwichArray = array();
  protected $date;
  */

  protected  $table = "commande";
  protected  $primaryKey = "id" ;

 /* public function __construct($nom, $email){
     $factory = new \RandomLib\Factory;
     $generator = $factory->getMediumStrengthGenerator();
     $this->token = $generator->generateInt(32);
     $this->state = 'created';
     $this->nom = $nom;
     $this->email = $email;
	}*/

  public function addSandwich($sandwich){
    $sandwichArray[] = $sandwich;
  }

  public function getToken(){
    return $this->token;
  }

}
