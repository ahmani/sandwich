<?php

require_once "../vendor/autoload.php";
require_once "../src/conf/autoload.php";
require_once "../src/lbs/utils/CommonsFunctions.php";

use \lbs\common\model\Categorie as Categorie;
use \lbs\common\model\Commande;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;


//Pour les requetes GET et POST, il faut positionner le header : access-control-allow-origin
//Pour les requetes PUT, DELETE... il faut reponse à la requete option par un code 203 "no content"
// et positionner les hearder : access-control-allow-origin , access-control-allow-methods, access-control-allow-headers

$capsule = new DB;

$parse = parse_ini_file("../src/conf/connex.ini");
$capsule->addConnection($parse);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$c = [
	'settings' => [
		'displayErrorDetails' => true,
	],
];
$c['notFoundHandler'] = function ($c) {
	return function ($request, $response) use ($c) {
		return $c['response']
		->withStatus(400)
		->withHeader('Content-Type', 'application/json;charset=utf8')
		->write(json_encode(array('Error' => 'Malformed Uri')));
	};
};

$c['notAllowedHandler'] = function ($c) {
	return function ($request, $response, $methods) use ($c) {
		return $c['response']
		->withStatus(405)
		->withHeader('Allow', implode(',', $methods) )
		->getBody()
		->write( 'méthode permises :' .implode(',', $methods) );
	};
};



/* categorie/id */


$app = new \Slim\App(new \Slim\Container($c));
$app->add('addheaders');

/**
* @apiGroup Categories
* @apiName GetCategorie
* @apiVersion 0.1.0
*
* @api {get} /categorie/id  accès à une ressource catégorie
*
* @apiDescription Accès à une ressource de type catégorie
* permet d'accéder à la représentation de la ressource categorie désignée.
* Retourne une représentation json de la ressource, incluant son nom et
* sa description.
*
* Le résultat inclut un lien pour accéder à la liste des ingrédients de cette catégorie.
*
* @apiParam {Number} id Identifiant unique de la catégorie
*
*
* @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
* @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
* @apiSuccess (Succès : 200) {String} description Description de la catégorie
* @apiSuccess (Succès : 200) {String} special 1 si la catégorie est "speciale", 0 sinon
*
* @apiSuccessExample {json} exemple de réponse en cas de succès
*     HTTP/1.1 200 OK
*
*     {
*            "id"  : 3 ,
*            "nom" : "crudités",
*            "description" : "nos salades et crudités fraiches et bio.",
*						"special": "1"
*     }
*
* @apiError (Erreur : 404) no query results
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 404 Not Found
*
*     {
*       "error" : "Catégorie inexistante"
*     }
*/

$app->get('/categorie/{id}',
function (Request $req, Response $resp, $args) {
	return (new lbs\api\PublicController($this))->getcategorie($req,$resp,$args);
}
)->setName('categorie');

/* collection de categories */

/**
* @apiGroup Categories
* @apiName GetCategories
* @apiVersion 0.1.0
*
* @api {get} /categories accès à une collections de catégories
*
* @apiDescription Accès à une collection de ressources de types catégorie
* permet d'accéder à la représentation de la collection de toute les ressources de types categorie.
* Retourne une représentation json de la collection, incluant son nom et
* sa description.
*
* Le résultat inclut un lien pour accéder à chaque catégories.
*
* @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
* @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
* @apiSuccess (Succès : 200) {String} description Description de la catégorie
*
* @apiSuccessExample {json} exemple de réponse en cas de succès
*     HTTP/1.1 200 OK
* {
*        "categorie": {
*          "id": "1",
*          "nom": "salades",
*          "description": "Nos bonnes salades, fraichement livrées par nos producteurs bios et locaux",
*          "special": "0"
*      },
*      "links": {
*          "self": {
*              "href": "/api/api.php/categorie/1"
*          }
*      }
*  },
*  {
*      "categorie": {
*          "id": "2",
*          "nom": "crudités",
*          "description": "Nos crudités variées  et préparées avec soin, issues de producteurs locaux et bio pour la plupart.",
*          "special": "0"
*      },
*      "links": {
*          "self": {
*              "href": "/api/api.php/categorie/2"
*          }
*      }
*  },
*  {
*      "categorie": {
*          "id": "3",
*          "nom": "viandes",
*          "description": "Nos viandes finement découpées et cuites comme vous le préférez. Viande issue d'élevages certifiés et locaux.",
*          "special": "1"
*      },
*      "links": {
*          "self": {
*              "href": "/api/api.php/categorie/3"
*          }
*      }
*  },
*  {
*      "categorie": {
*          "id": "4",
*          "nom": "Fromages",
*          "description": "Nos fromages bios et au lait cru. En majorité des AOC.",
*          "special": "1"
*      },
*      "links": {
*          "self": {
*            "href": "/api/api.php/categorie/4"
*          }
*        }
*  },
*  {
*      "categorie": {
*            "id": "5",
*          "nom": "Sauces",
*          "description": "Toutes les sauces du monde !",
*          "special": "0"
*  *      "links": {
*        "self": {
*            "href": "/api/api.php/categorie/5"
*      }
*  }
*}
*
* @apiError (Erreur : 404) no query results
*
*/
$app->get('/categories',
function (Request $req, Response $resp, $args) {
	return (new lbs\api\PublicController($this))->getcategories($req,$resp,$args);
}
)->setName('categories');

/*ressource ingredient/id*/

/**
* @apiGroup Categories
* @apiName GetIngredient
* @apiVersion 0.1.0
*
* @api {get} /ingredient/id  accès à une ressource ingredient
*
* @apiDescription Accès à une ressource de type ingredient
* permet d'accéder à la représentation de la ressource ingredient désignée.
* Retourne une représentation json de la ressource, incluant son nom, son fournisseur et
* sa description.
*
* @apiParam {Number} id Identifiant unique de l'ingredient
* @apiSuccess (Succès : 200) {String} nom Nom de l'ingredient
* @apiSuccess (Succès : 200) {String} description Description de l'ingredient
* @apiSuccess (Succès : 200) {String} fournisseur Fournisseur de l'ingredient
* @apiSuccess (Succès : 200) {String} image Image de l'ingredient
*
* @apiSuccessExample {json} exemple de réponse en cas de succès
* {
*     "id": "1",
*     "nom": "laitue",
*     "cat_id": "1",
*     "description": "belle laitue verte",
*     "fournisseur": "ferme \"la bonne salade\"",
*     "img": null
* }
*
* @apiError (Erreur : 404) no query results
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 404 Not Found
*		"No query results for model [lbs\common\model\Ingredient]."
*/
$app->get('/ingredient/{id}',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->getingredient($req,$resp,$args);
}
)->setName('ingredient');

/* collection d'ingredients pour 1 categorie */

/**
* @apiGroup Categories
* @apiName Ingredients par catégorie
* @apiVersion 0.1.0
*
* @api {get} /ingredients/cat_id accès à une collections d'ingredients pour une categorie donnée
*
* @apiDescription Accès à une collection de ressources de types ingredient pour une categorie
* permet d'accéder à la représentation de la collection de toute les ressources ingredient pour une catégorie donnée.
* Retourne une représentation json de la collection, incluant son nom et
* sa description.
*
* Le résultat inclut un lien pour accéder à chaque ingredient.
*
* @apiSuccess (Succès : 200) {Number} id Identifiant de l'ingredient'
* @apiSuccess (Succès : 200) {String} nom Nom de l'ingredient
* @apiSuccess (Succès : 200) {Number} cat_id Identifiant de la categorie a laquelle appartient l'ingredient
* @apiSuccess (Succès : 200) {String} description Description de la catégorie
** @apiSuccess (Succès : 200) {String} fournisseur Fournisseur de l'ingredient
** @apiSuccess (Succès : 200) {String} img Image de l'ingredient
*
* @apiSuccessExample {json} exemple de réponse en cas de succès
*     HTTP/1.1 200 OK
*		 {
*		 "ingredient": {
*				 "id": "1",
*				 "nom": "laitue",
*				 "cat_id": "1",
*			 "description": "belle laitue verte",
*				 "fournisseur": "ferme \"la bonne salade\"",
*				 "img": null
*		 },
*	 "links": {
*				 "self": {
*						 "href": "/api/api.php/ingredient/1"
*			 }
*		 }
*},
*{
*	 "ingredient": {
*			 "id": "2",
*			 "nom": "roquette",
*				 "cat_id": "1",
*				 "description": "la roquette qui pète ! bio, bien sur, et sauvage",
*				 "fournisseur": "ferme \"la bonne salade\"",
*				 "img": null
*		 },
*		 "links": {
*				 "self": {
*						 "href": "/api/api.php/ingredient/2"
*				 }
*		 }
*}
*
* @apiError (Erreur : 404) no query results
*
*/
$app->get('/ingredients/{cat_id}',
function (Request $req, Response $resp, $args) {
	return (new lbs\api\PublicController($this))->getIngredientsByCategory($req,$resp,$args);
}
)->setName('ingredientsByCat');

/* categorie d'un ingredient */

/**
* @apiGroup Categories
* @apiName GetIngredientCat
* @apiVersion 0.1.0
*
* @api {get} /ingredientcat/id  accès à une ressource ingredient et sa categorie
*
* @apiDescription Accès à une ressource de type ingredient et sa categorie
* permet d'accéder à la représentation de la ressource ingredient désignée, et sa catégorie.
* Retourne une représentation json de la ressource, incluant son nom, son fournisseur et
* sa description, de meme pour sa catégorie.
*
* @apiParam {Number} id Identifiant unique de l'ingredient
* @apiSuccess (Succès : 200) {String} nom Nom de l'ingredient
* @apiSuccess (Succès : 200) {String} description Description de l'ingredient
* @apiSuccess (Succès : 200) {String} fournisseur Fournisseur de l'ingredient
* @apiSuccess (Succès : 200) {String} image Image de l'ingredient
*
* @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
* @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
* @apiSuccess (Succès : 200) {String} description Description de la catégorie
* @apiSuccess (Succès : 200) {Number} special 1 si la catégorie est "speciale", 0 sinon
*
* @apiSuccessExample {json} exemple de réponse en cas de succès
* {
*    "id": "1",
*    "nom": "laitue",
*    "cat_id": "1",
*    "description": "belle laitue verte",
*    "fournisseur": "ferme \"la bonne salade\"",
*    "img": null,
*    "categorie": {
*        "id": "1",
*        "nom": "salades",
*        "description": "Nos bonnes salades, fraichement livrées par nos producteurs bios et locaux",
*        "special": "0"
*    }
*}
*
* @apiError (Erreur : 404) no query results
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 404 Not Found
*		"No query results for model [lbs\common\model\Ingredient]."
*/
$app->get('/ingredientcat/{id}',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->getingredientcat($req,$resp,$args);
}
)->setName('IngredientCat');

/* creer une commande */

/**
* @apiGroup Commandes
* @apiName CreateCommande
* @apiVersion 0.1.0
*
* @api {post} /commandes  création d'une ressource commande
*
* @apiDescription Création d'une ressource de type Commande
* La commande est ajoutée dans la base, son id est créé.
* Le nom du client, l'email, la date et la date doivent être fournis
*
*
* @apiParam  (request parameters) {String} nom_client Nom du client
* @apiParam  (request parameters) {String} email Email du client
* @apiParam  (request parameters) {String} date Date de la commmande (YYYY-MM-JJ)
* @apiParam  (request parameters) {String} date_retrait Date de retrait de la commmande (YYYY-MM-JJ)
* @apiHeader (request headers) {String} Content-Type:=application/json format utilisé pour les données transmises
*
* @apiParamExample {request} exemple de paramètres
*     {
*       "nom_client"         : "Jean",
*       "email" : "jean@wanadoo.com",
*			"date" : "2017-01-01",
*			"date" : "2017-01-02"
*     }
*
* @apiExample Exemple de requête :
*    POST /categories/ HTTP/1.1
*    Host: api.lbs.local
*    Content-Type: application/json;charset=utf8
*   {
*       "nom_client"         : "Jean",
*       "email" : "jean@wanadoo.com",
*			"date" : "2017-01-01",
*			"date" : "2017-01-02"
*     }
*
* @apiSuccess (Réponse : 201) {json} commande représentation json de la nouvelle commande

* @apiHeader (response headers) {String} Content-Type: format de représentation de la ressource réponse
*
* @apiSuccessExample {response} exemple de réponse en cas de succès
*     HTTP/1.1 201 CREATED
* {
*  "token": "r6884sys44jsk51tx34ooouhluf7obsg",
*  "nom_client": "jaja",
*  "email": "juju@jaja.jojo",
*  "date": "2017-2-26",
*  "date_retrait": "2017-01-02",
*  "montant": 0,
*  "id": 4
* }
*
* @apiError (Réponse : 400) MissingParameter paramètre manquant dans la requête
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 400 Bad Request
*     {
*       "error" : "missing parameter : nom"
*     }
*/
$app->post('/commandes',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->createCommande($req, $resp, $args);
}
)->setName('createCommande');

//Créer un sandwich d'une commande existante


$app->post('/commande/{id}/sandwich',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->CreateSandwich($req, $resp, $args);
}
)->setName('createSandwich')
->add('checkToken');

// Modifier un sandwich d'une commande existante

/**
* @apiGroup Commandes
* @apiName updateSandwich
* @apiVersion 0.1.0
*
* @api {post} /commandes/id/sandwichs/id_sandwich modification d'un sandwich dans une commande
*
* @apiDescription modification d'un sandwich dans une commande
*
* @apiHeader (request headers) {String} Content-Type:=application/json format utilisé pour les données transmises
*
*
* @apiExample Exemple de requête :
*    POST /categories/ HTTP/1.1
*    Host: api.lbs.local
*    Content-Type: application/json;charset=utf8
*   {
*       "nom_client"         : "Jean",
*       "email" : "jean@wanadoo.com",
*			"date" : "2017-01-01",
*			"date" : "2017-01-02"
*     }
*
* @apiSuccess (Réponse : 201) {json} commande représentation json de la nouvelle commande

* @apiHeader (response headers) {String} Content-Type: format de représentation de la ressource réponse
*
* @apiSuccessExample {response} exemple de réponse en cas de succès
*     HTTP/1.1 201 CREATED
*
* @apiError (Réponse : 400) MissingParameter paramètre manquant dans la requête
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 400 Bad Request
*     {
*       "error" : "missing parameter : nom"
*     }
*/
$app->put('/commandes/{id}/sandwichs/{id_sandwich}',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->updateSandwich($req, $resp, $args);
}
)->setName('updateSandwich')
->add('checkToken');

//fonction pour etat d'une commande

/**
* @apiGroup Commandes
* @apiName GetEtatCommande
* @apiVersion 0.1.0
*
* @api {get} /etatcommande/id accès à une commande
*
* @apiDescription Accès à l'état commande
* permet d'accéder à l'état de la commande désignée.
* Retourne une représentation json de la ressource commande, et un lien vers la commande
*
* @apiParam {Number} id Identifiant unique de la commande
* @apiSuccess (Succès : 200) {String} token Token unique de la commande
* @apiSuccess (Succès : 200) {String} etat Etat de la commande
* @apiSuccess (Succès : 200) {String} nom_client Nom du client qui a passé la commande
* @apiSuccess (Succès : 200) {String} email Email du client
* @apiSuccess (Succès : 200) {String} date Date de la commande
* @apiSuccess (Succès : 200) {String} date_retrait Date de retrait de la commande
* @apiSuccess (Succès : 200) {String} montant Montant de la commande
*
* @apiSuccessExample {json} exemple de réponse en cas de succès
* {
*	 "commande": {
*			 "id": "4",
*			 "token": "r6884sys44jsk51tx34ooouhluf7obsg",
*			 "etat": "created",
*			 "nom_client": "jaja",
*			 "email": "juju@jaja.jojo",
*			 "date": "2017-02-26 00:00:00",
*			 "date_retrait": "2017-01-02 00:00:00",
*			 "montant": "0"
*	 },
*	 "links": {
*			 "self": {
*					 "href": "/api/api.php/etatcommande/4"
*			 }
*	 }
* }
*
* @apiError (Erreur : 404) no query results
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 404 Not Found
*		"No query results for model [lbs\common\model\Commande."
*/
$app->get('/etatcommande/{id}',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->getEtatCommande($req,$resp,$args);
}
) ->setName('etatCommande');

//fonction pour obtenir une facture pour une commande livree

/**
* @apiGroup Commandes
* @apiName GetBillCommande
* @apiVersion 0.1.0
*
* @api {get} /etatcommande/id accès à la facture d'une commande
*
* @apiDescription Accès à l'état commande
* Retourne une représentation json de la ressource commande avec tout ses ingredients
*
*
* @apiSuccessExample {json} exemple de réponse en cas de succès
* {
*    "0": [
*        {
*            "Taille": "petite faim",
*            "Type": "blanc",
*            "ingredients": {
*                "salades": "laitue",
*                "crudités": "carottes",
*                "Fromages": "chèvre frais",
*                "Sauces": "salsa habanera"
*            }
*        },
*        {
*            "Taille": "petite faim",
*            "Type": "blanc",
*            "ingredients": {
*                "salades": "laitue",
*                "crudités": "carottes",
*                "Fromages": "chèvre frais",
*                "Sauces": "salsa habanera"
*            }
*        }
*    ],
*    "montant de la commande": "32"
* }
*
* @apiError (Erreur : 404) no query results
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 404 Not Found
*		"No query results for model [lbs\common\model\Commande."
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 400
*		{
*    "Erreur": "la commande n'est pas encore livree"
*   }
*/
$app->get('/factureCommande/{id}',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->getBill($req,$resp,$args);
}
)->setName('factureCommande');

// Supprimer une commande

/**
* @apiGroup Commandes
* @apiName DeleteCommande
* @apiVersion 0.1.0
*
* @api {delete} /commande/id supprime une commande
*
* @apiDescription Supprimer une commande
* Supprime une commande dans la base
*
*
* @apiSuccessExample {json} exemple de réponse en cas de succès
* {"Succes":"La commande a été supprimée avec succes"}
*
* @apiError (Erreur : 404) no query results
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 404 Not Found
*		"No query results for model [lbs\common\model\Commande."
*
*/
$app->delete('/commande/{id}',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->DeleteCommande($req, $resp, $args);
}
)->setName('deleteCommande')
->add('checkToken');

/**
* @apiGroup Commandes
* @apiName payCommande
* @apiVersion 0.1.0
*
* @api {put} /commande/id/pay Envoie les information de paiement
* @apiDescription Envoi des informations de paiement
*Le nom, prenom, numero de carte, cyrptogramme et montant doivent etre envoyés
*
 * @apiExample Exemple de requête :
 *    POST /categories/ HTTP/1.1
 *    Host: api.lbs.local
 *    Content-Type: application/json;charset=utf8
 *
 *    {
 *       "nom"         : "Dupont",
 *			 "prenom" : "Jean",
 *			 "numCarte" : 123456,
 *			 "cryptogramme" : 123,
 *			"montant" : 32
 *    }
 *
* @apiSuccessExample {json} exemple de réponse en cas de succès
*{"Succes":"commande mise à jour"}
*
* @apiError (Erreur : 404) no query results
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 404 Not Found
*		"No query results for model [lbs\common\model\Commande."
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 400
* {"Erreur":"les montants ne correspondent pas"}
*/
$app->put('/commande/{id}/pay',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->payCommande($req, $resp, $args);
}
)->setName('payCommande');

// Modifier la date de livraison d'une commande

/**
* @apiGroup Commandes
* @apiName updateCommande
* @apiVersion 0.1.0
*
* @api {put} /commande/id Modifie la date de livraison d'une commande
* @apiDescription Modifier la date de retrait d'une commande
*La nouvelle date doit être fournie
*
 * @apiExample Exemple de requête :
 *    POST /categories/ HTTP/1.1
 *    Host: api.lbs.local
 *    Content-Type: application/json;charset=utf8
 *
 *    {
 *       "date_retrait"         : 2017-01-03
 *    }
 *
* @apiSuccessExample {json} exemple de réponse en cas de succès
*{"Succes":"commande mise à jour"}
*
* @apiError (Erreur : 404) no query results
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 404 Not Found
*		"No query results for model [lbs\common\model\Commande."
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 400
* {"Erreur":"une erreur est survenu"}
*/
$app->put('/commandes/{id}',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->updateCommande($req, $resp, $args);
}
)->setName('updateCommande');

/**
* @apiGroup Commandes
* @apiName getCommande
* @apiVersion 0.1.0
*
* @api {get} /commande/id renvoie toute les informations sur une commande
* @apiDescription Recuperer toute les informations d'une commande
*
*
* @apiSuccessExample {json} exemple de réponse en cas de succès
* {
*  "id": "2",
*  "token": "4nun78lccu1njywv5cb4f56glbovp9rn",
*  "etat": "paid",
*  "nom_client": "ikram",
*  "email": "ikram@gmail.com",
*  "date": "2017-01-31 00:00:00",
*  "montant": "32",
*  "date_retrait": "2017-02-03 00:00:00",
*  "sandwichs": [
*    {
*      "id": "22",
*      "id_commande": "2",
*      "id_size": "1",
*      "id_type": "1"
*    },
*    {
*      "id": "23",
*      "id_commande": "2",
*      "id_size": "1",
*      "id_type": "1"
*    }
*  ]
* }
*
* @apiError (Erreur : 404) no query results
*
* @apiErrorExample {json} exemple de réponse en cas d'erreur
*     HTTP/1.1 404 Not Found
*		"No query results for model [lbs\common\model\Commande."
*
*/
$app->get('/commande/{id}',
function (Request $req, Response $resp, $args){
	return (new lbs\api\PublicController($this))->getCommandeDescription($req, $resp, $args);
}
)->setName('getCommandeDescription');

$app->run();
