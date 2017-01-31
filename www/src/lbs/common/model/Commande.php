<?php

namespace lbs\common\model;
use Illuminate\Database\Eloquent\Model as Model;

Class Commande extends Model{
  protected $token;
  protected $primaryKey = "id";
  //protected $state; //{'created' ; 'paid' ; 'progress' ; 'ready' ; 'delivered'}
  //protected $nom_client;
  //protected $email;
  protected $table = "commande";
  //protected $date;
  //protected $montant;
  public $timestamps =false;

  public function __construct(){
	}

  public function sandwichs()
  {
    return $this->hasMany('lbs\common\model\sandwich', 'id_commande');
  }

  public function getToken(){
    return $this->token;
  }
}
