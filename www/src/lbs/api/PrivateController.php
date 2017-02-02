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

			$tab = GetSandwichsByCommande($value->id);
			$commande_details[] = array("Nom du client" => $commande->nom_client,
						   "Email" => $commande->email,
						   "Date de création" => $commande->date,
						   "Date de retrait" => $commande->date_retrait,
						   "Etat" => $commande->etat,
						   "Sandwichs" => $tab);

	}



}
