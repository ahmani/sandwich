<?php

namespace lbs\api;

use lbs\common\model\Categorie;
use lbs\common\model\Ingredient;
use lbs\common\model\Commande;
use lbs\common\model\size;
use lbs\common\model\type;
use lbs\common\model\Sandwich;

Class PrivateController
{

	private $cont;

	public function __construct($var)
	{
		$this->cont= $var;
	}

	public function getcommandes($req,$rs,$args)
	{
		$cat = Commande::select()->orderBy('date_retrait','DESC')->orderBy('date','DESC')->get();
		$commande_details = array();
		$rs = $rs->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf8');
		$commandes = json_decode($cat->toJson());

		foreach ($commandes as $value) {
			$tab = GetSandwichsByCommande($value->id);
			$commande_details[] = array("Nom du client" => $value->nom_client,
						   "Email" => $value->email,
						   "Date de création" => $value->date,
						   "Date de retrait" => $value->date_retrait,
						   "Etat" => $value->etat,
						   "Sandwichs" => $tab);
		}
		$rs = $rs->withJson($commande_details, 200);
		return $rs;

	}

	public function getCommandeDetail($req,$resp,$args)
	{
		if($args['id'])
			{
				$commande = Commande::where('id', '=', $args['id'])->firstOrFail();
			}
		else
			{
				return json_error($rs,500,"Id commande required");
			}

			$tab = GetSandwichsByCommande($commande->id);
			$commande_details[] = array("Nom du client" => $commande->nom_client,
						   "Email" => $commande->email,
						   "Date de création" => $commande->date,
						   "Date de retrait" => $commande->date_retrait,
						   "Etat" => $commande->etat,
						   "Sandwichs" => $tab);
			$resp = $resp->withJson($commande_details, 200);
			return $resp;
	}

	public function getPaginatedCommandes($req, $resp, $args){
		$offset = $req->getQueryParams()['offset'];
		$limit = $req->getQueryParams()['limit'];

		$com = Commande::take($limit)->offset($offset)->get();
		$resp = $resp->withJson($com, 200);
		return $resp;
	}


//changement de l'etat d'une commande
	public function changeCommandStatus($req, $resp, $args)
	{
		$commande = Commande::select()->where('id', '=', $args['id'])->firstOrFail();
		$newEtat = filter_var($req->getParsedBody()['etat'], FILTER_SANITIZE_STRING);

		if (!empty($commande))
		{
			$old_status = $commande->etat;

			switch ($newEtat) {
			  case "progress":
			    if ($old_status == "paid")
		      	$commande->etat = $newEtat;
	      break;
			  case "ready":
			    if ($old_status == "progess")
			      $commande->etat = $newEtat;
			  break;
			  case "delivered":
			    if ($old_status == "ready")
			    	$commande->etat = $newEtat;
			  break;
			  default:
			    return json_error($resp, 500, "Transition incorrecte");
			}
			$commande->save();
			return json_success($resp,200, 'Etat de la commande mis à jour');
		}

		return json_error($resp, 404, "Not found");
	}

}
