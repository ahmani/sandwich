<?php

namespace lbs\common\model;
use Illuminate\Database\Eloquent\Model as Model;

Class Commande extends Model{
  protected $token;
  protected $primaryKey = "id";
  protected $state; //{'created' ; 'paid' ; 'progress' ; 'ready' ; 'delivered'}
  protected $nom_client;
  protected $email;
  protected $sandwichArray = array();
  protected $table = "commande";
  protected $date;
  public $timestamps =false;

  public function __construct(){

	}

  public function addSandwich($sandwich){
    $sandwichArray[] = $sandwich;
  }

  public function getToken(){
    return $this->token;
  }

}
