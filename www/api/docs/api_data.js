define({ "api": [
  {
    "group": "Categories",
    "name": "GetCategorie",
    "version": "0.1.0",
    "type": "get",
    "url": "/categorie/id",
    "title": "accès à une ressource catégorie",
    "description": "<p>Accès à une ressource de type catégorie permet d'accéder à la représentation de la ressource categorie désignée. Retourne une représentation json de la ressource, incluant son nom et sa description.</p> <p>Le résultat inclut un lien pour accéder à la liste des ingrédients de cette catégorie.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant unique de la catégorie</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant de la catégorie</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "nom",
            "description": "<p>Nom de la catégorie</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Description de la catégorie</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "special",
            "description": "<p>1 si la catégorie est &quot;speciale&quot;, 0 sinon</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "    HTTP/1.1 200 OK\n\n    {\n           \"id\"  : 3 ,\n           \"nom\" : \"crudités\",\n           \"description\" : \"nos salades et crudités fraiches et bio.\",\n\t\t\t\t\t\t\"special\": \"1\"\n    }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 404 Not Found\n\n{\n  \"error\" : \"Catégorie inexistante\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Categories"
  },
  {
    "group": "Categories",
    "name": "GetCategories",
    "version": "0.1.0",
    "type": "get",
    "url": "/categories",
    "title": "accès à une collections de catégories",
    "description": "<p>Accès à une collection de ressources de types catégorie permet d'accéder à la représentation de la collection de toute les ressources de types categorie. Retourne une représentation json de la collection, incluant son nom et sa description.</p> <p>Le résultat inclut un lien pour accéder à chaque catégories.</p>",
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant de la catégorie</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "nom",
            "description": "<p>Nom de la catégorie</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Description de la catégorie</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "    HTTP/1.1 200 OK\n{\n       \"categorie\": {\n         \"id\": \"1\",\n         \"nom\": \"salades\",\n         \"description\": \"Nos bonnes salades, fraichement livrées par nos producteurs bios et locaux\",\n         \"special\": \"0\"\n     },\n     \"links\": {\n         \"self\": {\n             \"href\": \"/api/api.php/categorie/1\"\n         }\n     }\n },\n {\n     \"categorie\": {\n         \"id\": \"2\",\n         \"nom\": \"crudités\",\n         \"description\": \"Nos crudités variées  et préparées avec soin, issues de producteurs locaux et bio pour la plupart.\",\n         \"special\": \"0\"\n     },\n     \"links\": {\n         \"self\": {\n             \"href\": \"/api/api.php/categorie/2\"\n         }\n     }\n },\n {\n     \"categorie\": {\n         \"id\": \"3\",\n         \"nom\": \"viandes\",\n         \"description\": \"Nos viandes finement découpées et cuites comme vous le préférez. Viande issue d'élevages certifiés et locaux.\",\n         \"special\": \"1\"\n     },\n     \"links\": {\n         \"self\": {\n             \"href\": \"/api/api.php/categorie/3\"\n         }\n     }\n },\n {\n     \"categorie\": {\n         \"id\": \"4\",\n         \"nom\": \"Fromages\",\n         \"description\": \"Nos fromages bios et au lait cru. En majorité des AOC.\",\n         \"special\": \"1\"\n     },\n     \"links\": {\n         \"self\": {\n           \"href\": \"/api/api.php/categorie/4\"\n         }\n       }\n },\n {\n     \"categorie\": {\n           \"id\": \"5\",\n         \"nom\": \"Sauces\",\n         \"description\": \"Toutes les sauces du monde !\",\n         \"special\": \"0\"\n *      \"links\": {\n       \"self\": {\n           \"href\": \"/api/api.php/categorie/5\"\n     }\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      }
    },
    "filename": "api/api.php",
    "groupTitle": "Categories"
  },
  {
    "group": "Categories",
    "name": "GetIngredient",
    "version": "0.1.0",
    "type": "get",
    "url": "/ingredient/id",
    "title": "accès à une ressource ingredient",
    "description": "<p>Accès à une ressource de type ingredient permet d'accéder à la représentation de la ressource ingredient désignée. Retourne une représentation json de la ressource, incluant son nom, son fournisseur et sa description.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant unique de l'ingredient</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "nom",
            "description": "<p>Nom de l'ingredient</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Description de l'ingredient</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "fournisseur",
            "description": "<p>Fournisseur de l'ingredient</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "image",
            "description": "<p>Image de l'ingredient</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "{\n    \"id\": \"1\",\n    \"nom\": \"laitue\",\n    \"cat_id\": \"1\",\n    \"description\": \"belle laitue verte\",\n    \"fournisseur\": \"ferme \\\"la bonne salade\\\"\",\n    \"img\": null\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 404 Not Found\n\t\t\"No query results for model [lbs\\common\\model\\Ingredient].\"",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Categories"
  },
  {
    "group": "Categories",
    "name": "GetIngredientCat",
    "version": "0.1.0",
    "type": "get",
    "url": "/ingredientcat/id",
    "title": "accès à une ressource ingredient et sa categorie",
    "description": "<p>Accès à une ressource de type ingredient et sa categorie permet d'accéder à la représentation de la ressource ingredient désignée, et sa catégorie. Retourne une représentation json de la ressource, incluant son nom, son fournisseur et sa description, de meme pour sa catégorie.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant unique de l'ingredient</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "nom",
            "description": "<p>Nom de l'ingredient</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Description de l'ingredient</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "fournisseur",
            "description": "<p>Fournisseur de l'ingredient</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "image",
            "description": "<p>Image de l'ingredient</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant de la catégorie</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "special",
            "description": "<p>1 si la catégorie est &quot;speciale&quot;, 0 sinon</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "{\n   \"id\": \"1\",\n   \"nom\": \"laitue\",\n   \"cat_id\": \"1\",\n   \"description\": \"belle laitue verte\",\n   \"fournisseur\": \"ferme \\\"la bonne salade\\\"\",\n   \"img\": null,\n   \"categorie\": {\n       \"id\": \"1\",\n       \"nom\": \"salades\",\n       \"description\": \"Nos bonnes salades, fraichement livrées par nos producteurs bios et locaux\",\n       \"special\": \"0\"\n   }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 404 Not Found\n\t\t\"No query results for model [lbs\\common\\model\\Ingredient].\"",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Categories"
  },
  {
    "group": "Categories",
    "name": "Ingredients_par_cat_gorie",
    "version": "0.1.0",
    "type": "get",
    "url": "/ingredients/cat_id",
    "title": "accès à une collections d'ingredients pour une categorie donnée",
    "description": "<p>Accès à une collection de ressources de types ingredient pour une categorie permet d'accéder à la représentation de la collection de toute les ressources ingredient pour une catégorie donnée. Retourne une représentation json de la collection, incluant son nom et sa description.</p> <p>Le résultat inclut un lien pour accéder à chaque ingredient.</p>",
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant de l'ingredient'</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "nom",
            "description": "<p>Nom de l'ingredient</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "cat_id",
            "description": "<p>Identifiant de la categorie a laquelle appartient l'ingredient</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Description de la catégorie</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "fournisseur",
            "description": "<p>Fournisseur de l'ingredient</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "img",
            "description": "<p>Image de l'ingredient</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "    HTTP/1.1 200 OK\n\t\t {\n\t\t \"ingredient\": {\n\t\t\t\t \"id\": \"1\",\n\t\t\t\t \"nom\": \"laitue\",\n\t\t\t\t \"cat_id\": \"1\",\n\t\t\t \"description\": \"belle laitue verte\",\n\t\t\t\t \"fournisseur\": \"ferme \\\"la bonne salade\\\"\",\n\t\t\t\t \"img\": null\n\t\t },\n\t \"links\": {\n\t\t\t\t \"self\": {\n\t\t\t\t\t\t \"href\": \"/api/api.php/ingredient/1\"\n\t\t\t }\n\t\t }\n},\n{\n\t \"ingredient\": {\n\t\t\t \"id\": \"2\",\n\t\t\t \"nom\": \"roquette\",\n\t\t\t\t \"cat_id\": \"1\",\n\t\t\t\t \"description\": \"la roquette qui pète ! bio, bien sur, et sauvage\",\n\t\t\t\t \"fournisseur\": \"ferme \\\"la bonne salade\\\"\",\n\t\t\t\t \"img\": null\n\t\t },\n\t\t \"links\": {\n\t\t\t\t \"self\": {\n\t\t\t\t\t\t \"href\": \"/api/api.php/ingredient/2\"\n\t\t\t\t }\n\t\t }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      }
    },
    "filename": "api/api.php",
    "groupTitle": "Categories"
  },
  {
    "group": "Commandes",
    "name": "CreateCommande",
    "version": "0.1.0",
    "type": "post",
    "url": "/commandes",
    "title": "création d'une ressource commande",
    "description": "<p>Création d'une ressource de type Commande La commande est ajoutée dans la base, son id est créé. Le nom du client, l'email, la date et la date doivent être fournis</p>",
    "parameter": {
      "fields": {
        "request parameters": [
          {
            "group": "request parameters",
            "type": "String",
            "optional": false,
            "field": "nom_client",
            "description": "<p>Nom du client</p>"
          },
          {
            "group": "request parameters",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email du client</p>"
          },
          {
            "group": "request parameters",
            "type": "String",
            "optional": false,
            "field": "date",
            "description": "<p>Date de la commmande (YYYY-MM-JJ)</p>"
          },
          {
            "group": "request parameters",
            "type": "String",
            "optional": false,
            "field": "date_retrait",
            "description": "<p>Date de retrait de la commmande (YYYY-MM-JJ)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de paramètres",
          "content": "    {\n      \"nom_client\"         : \"Jean\",\n      \"email\" : \"jean@wanadoo.com\",\n\t\t\t\"date\" : \"2017-01-01\",\n\t\t\t\"date\" : \"2017-01-02\"\n    }",
          "type": "request"
        }
      ]
    },
    "header": {
      "fields": {
        "request headers": [
          {
            "group": "request headers",
            "type": "String",
            "optional": false,
            "field": "Content-Type:",
            "defaultValue": "application/json",
            "description": "<p>format utilisé pour les données transmises</p>"
          }
        ],
        "response headers": [
          {
            "group": "response headers",
            "type": "String",
            "optional": false,
            "field": "Content-Type:",
            "description": "<p>format de représentation de la ressource réponse</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Exemple de requête :",
        "content": "   POST /categories/ HTTP/1.1\n   Host: api.lbs.local\n   Content-Type: application/json;charset=utf8\n  {\n      \"nom_client\"         : \"Jean\",\n      \"email\" : \"jean@wanadoo.com\",\n\t\t\t\"date\" : \"2017-01-01\",\n\t\t\t\"date\" : \"2017-01-02\"\n    }",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Réponse : 201": [
          {
            "group": "Réponse : 201",
            "type": "json",
            "optional": false,
            "field": "commande",
            "description": "<p>représentation json de la nouvelle commande</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "    HTTP/1.1 201 CREATED\n{\n \"token\": \"r6884sys44jsk51tx34ooouhluf7obsg\",\n \"nom_client\": \"jaja\",\n \"email\": \"juju@jaja.jojo\",\n \"date\": \"2017-2-26\",\n \"date_retrait\": \"2017-01-02\",\n \"montant\": 0,\n \"id\": 4\n}",
          "type": "response"
        }
      ]
    },
    "error": {
      "fields": {
        "Réponse : 400": [
          {
            "group": "Réponse : 400",
            "optional": false,
            "field": "MissingParameter",
            "description": "<p>paramètre manquant dans la requête</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 400 Bad Request\n{\n  \"error\" : \"missing parameter : nom\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "DeleteCommande",
    "version": "0.1.0",
    "type": "delete",
    "url": "/commande/id",
    "title": "supprime une commande",
    "description": "<p>Supprimer une commande Supprime une commande dans la base</p>",
    "success": {
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "{\"Succes\":\"La commande a été supprimée avec succes\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 404 Not Found\n\t\t\"No query results for model [lbs\\common\\model\\Commande.\"",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "GetBillCommande",
    "version": "0.1.0",
    "type": "get",
    "url": "/etatcommande/id",
    "title": "accès à la facture d'une commande",
    "description": "<p>Accès à l'état commande Retourne une représentation json de la ressource commande avec tout ses ingredients</p>",
    "success": {
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "{\n   \"0\": [\n       {\n           \"Taille\": \"petite faim\",\n           \"Type\": \"blanc\",\n           \"ingredients\": {\n               \"salades\": \"laitue\",\n               \"crudités\": \"carottes\",\n               \"Fromages\": \"chèvre frais\",\n               \"Sauces\": \"salsa habanera\"\n           }\n       },\n       {\n           \"Taille\": \"petite faim\",\n           \"Type\": \"blanc\",\n           \"ingredients\": {\n               \"salades\": \"laitue\",\n               \"crudités\": \"carottes\",\n               \"Fromages\": \"chèvre frais\",\n               \"Sauces\": \"salsa habanera\"\n           }\n       }\n   ],\n   \"montant de la commande\": \"32\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 404 Not Found\n\t\t\"No query results for model [lbs\\common\\model\\Commande.\"",
          "type": "json"
        },
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 400\n\t\t{\n   \"Erreur\": \"la commande n'est pas encore livree\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "GetEtatCommande",
    "version": "0.1.0",
    "type": "get",
    "url": "/etatcommande/id",
    "title": "accès à une commande",
    "description": "<p>Accès à l'état commande permet d'accéder à l'état de la commande désignée. Retourne une représentation json de la ressource commande, et un lien vers la commande</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant unique de la commande</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token unique de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "etat",
            "description": "<p>Etat de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "nom_client",
            "description": "<p>Nom du client qui a passé la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email du client</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "date",
            "description": "<p>Date de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "date_retrait",
            "description": "<p>Date de retrait de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "montant",
            "description": "<p>Montant de la commande</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "{\n\t \"commande\": {\n\t\t\t \"id\": \"4\",\n\t\t\t \"token\": \"r6884sys44jsk51tx34ooouhluf7obsg\",\n\t\t\t \"etat\": \"created\",\n\t\t\t \"nom_client\": \"jaja\",\n\t\t\t \"email\": \"juju@jaja.jojo\",\n\t\t\t \"date\": \"2017-02-26 00:00:00\",\n\t\t\t \"date_retrait\": \"2017-01-02 00:00:00\",\n\t\t\t \"montant\": \"0\"\n\t },\n\t \"links\": {\n\t\t\t \"self\": {\n\t\t\t\t\t \"href\": \"/api/api.php/etatcommande/4\"\n\t\t\t }\n\t }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 404 Not Found\n\t\t\"No query results for model [lbs\\common\\model\\Commande.\"",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "getCommande",
    "version": "0.1.0",
    "type": "get",
    "url": "/commande/id",
    "title": "renvoie toute les informations sur une commande",
    "description": "<p>Recuperer toute les informations d'une commande</p>",
    "success": {
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "{\n \"id\": \"2\",\n \"token\": \"4nun78lccu1njywv5cb4f56glbovp9rn\",\n \"etat\": \"paid\",\n \"nom_client\": \"ikram\",\n \"email\": \"ikram@gmail.com\",\n \"date\": \"2017-01-31 00:00:00\",\n \"montant\": \"32\",\n \"date_retrait\": \"2017-02-03 00:00:00\",\n \"sandwichs\": [\n   {\n     \"id\": \"22\",\n     \"id_commande\": \"2\",\n     \"id_size\": \"1\",\n     \"id_type\": \"1\"\n   },\n   {\n     \"id\": \"23\",\n     \"id_commande\": \"2\",\n     \"id_size\": \"1\",\n     \"id_type\": \"1\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 404 Not Found\n\t\t\"No query results for model [lbs\\common\\model\\Commande.\"",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "payCommande",
    "version": "0.1.0",
    "type": "put",
    "url": "/commande/id/pay",
    "title": "Envoie les information de paiement",
    "description": "<p>Envoi des informations de paiement Le nom, prenom, numero de carte, cyrptogramme et montant doivent etre envoyés</p>",
    "examples": [
      {
        "title": "Exemple de requête :",
        "content": "   POST /categories/ HTTP/1.1\n   Host: api.lbs.local\n   Content-Type: application/json;charset=utf8\n\n   {\n      \"nom\"         : \"Dupont\",\n\t\t\t \"prenom\" : \"Jean\",\n\t\t\t \"numCarte\" : 123456,\n\t\t\t \"cryptogramme\" : 123,\n\t\t\t\"montant\" : 32\n   }",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "{\"Succes\":\"commande mise à jour\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 404 Not Found\n\t\t\"No query results for model [lbs\\common\\model\\Commande.\"",
          "type": "json"
        },
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 400\n{\"Erreur\":\"les montants ne correspondent pas\"}",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "updateCommande",
    "version": "0.1.0",
    "type": "put",
    "url": "/commande/id",
    "title": "Modifie la date de livraison d'une commande",
    "description": "<p>Modifier la date de retrait d'une commande La nouvelle date doit être fournie</p>",
    "examples": [
      {
        "title": "Exemple de requête :",
        "content": "POST /categories/ HTTP/1.1\nHost: api.lbs.local\nContent-Type: application/json;charset=utf8\n\n{\n   \"date_retrait\"         : 2017-01-03\n}",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "{\"Succes\":\"commande mise à jour\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "no",
            "description": "<p>query results</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 404 Not Found\n\t\t\"No query results for model [lbs\\common\\model\\Commande.\"",
          "type": "json"
        },
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "    HTTP/1.1 400\n{\"Erreur\":\"une erreur est survenu\"}",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "updateSandwich",
    "version": "0.1.0",
    "type": "post",
    "url": "/commandes/id/sandwichs/id_sandwich",
    "title": "modification d'un sandwich dans une commande",
    "description": "<p>modification d'un sandwich dans une commande</p>",
    "header": {
      "fields": {
        "request headers": [
          {
            "group": "request headers",
            "type": "String",
            "optional": false,
            "field": "Content-Type:",
            "defaultValue": "application/json",
            "description": "<p>format utilisé pour les données transmises</p>"
          }
        ],
        "response headers": [
          {
            "group": "response headers",
            "type": "String",
            "optional": false,
            "field": "Content-Type:",
            "description": "<p>format de représentation de la ressource réponse</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Exemple de requête :",
        "content": "   POST /categories/ HTTP/1.1\n   Host: api.lbs.local\n   Content-Type: application/json;charset=utf8\n  {\n      \"nom_client\"         : \"Jean\",\n      \"email\" : \"jean@wanadoo.com\",\n\t\t\t\"date\" : \"2017-01-01\",\n\t\t\t\"date\" : \"2017-01-02\"\n    }",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Réponse : 201": [
          {
            "group": "Réponse : 201",
            "type": "json",
            "optional": false,
            "field": "commande",
            "description": "<p>représentation json de la nouvelle commande</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 201 CREATED",
          "type": "response"
        }
      ]
    },
    "error": {
      "fields": {
        "Réponse : 400": [
          {
            "group": "Réponse : 400",
            "optional": false,
            "field": "MissingParameter",
            "description": "<p>paramètre manquant dans la requête</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 400 Bad Request\n{\n  \"error\" : \"missing parameter : nom\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/api.php",
    "groupTitle": "Commandes"
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "api/docs/main.js",
    "group": "_home_antoine_Documents_sandwich_www_api_docs_main_js",
    "groupTitle": "_home_antoine_Documents_sandwich_www_api_docs_main_js",
    "name": ""
  }
] });
