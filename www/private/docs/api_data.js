define({ "api": [
  {
    "group": "Commandes",
    "name": "changeCommandStatus",
    "version": "0.1.0",
    "type": "get",
    "url": "/commande/id",
    "title": "Change l'état d'une commande",
    "description": "<p>Change l'état d'une commande</p>",
    "success": {
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 200\n      \"Etat de la commande mis à jour\"",
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
          "content": "HTTP/1.1 404 Not Found\n  \"No query results for model [lbs\\common\\model\\Commande.\"",
          "type": "json"
        },
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 500\n  \"Transition incorrecte\"",
          "type": "json"
        }
      ]
    },
    "filename": "./api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "getCommandeDetail",
    "version": "0.1.0",
    "type": "get",
    "url": "/commande/id",
    "title": "renvoie tous les détails d'une commande",
    "description": "<p>Recuperer tous les détails d'une commande</p>",
    "success": {
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "[\n   {\n       \"Nom du client\": \"ikram\",\n       \"Email\": \"ikram.ahmani@gmail.com\",\n       \"Date de création\": \"2017-02-25 00:00:00\",\n       \"Date de retrait\": \"2017-02-22 18:25:00\",\n       \"Etat\": \"progress\",\n       \"Sandwichs\": [\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": []\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": []\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": []\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": {\n                   \"salades\": \"laitue\",\n                   \"crudités\": \"carottes\",\n                   \"viandes\": \"blanc de poulet\",\n                   \"Fromages\": \"chèvre frais\"\n               }\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": {\n                   \"salades\": \"laitue\",\n                   \"crudités\": \"carottes\",\n                   \"viandes\": \"blanc de poulet\",\n                   \"Fromages\": \"chèvre frais\"\n               }\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": {\n                   \"salades\": \"laitue\",\n                   \"crudités\": \"carottes\",\n                   \"viandes\": \"blanc de poulet\",\n                   \"Fromages\": \"chèvre frais\"\n               }\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": {\n                   \"salades\": \"laitue\",\n                   \"crudités\": \"carottes\",\n                   \"viandes\": \"blanc de poulet\",\n                   \"Fromages\": \"chèvre frais\"\n               }\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": {\n                   \"salades\": \"laitue\",\n                   \"crudités\": \"carottes\",\n                   \"viandes\": \"blanc de poulet\",\n                   \"Fromages\": \"chèvre frais\",\n                   \"Sauces\": \"vinaigrette huile d'olive\"\n               }\n           }\n       ]\n   }\n]",
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
        ],
        "Erreur : 500": [
          {
            "group": "Erreur : 500",
            "optional": false,
            "field": "Missing",
            "description": "<p>params</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 404 Not found\n  \"Not found\"",
          "type": "json"
        },
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 500 \n  \"Id commande required\"",
          "type": "json"
        }
      ]
    },
    "filename": "./api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "getCommandes",
    "version": "0.1.0",
    "type": "get",
    "url": "/commande/id",
    "title": "Renvoie la liste complète des commandes , triée par date de livraison et ordre de création",
    "description": "<p>Recuperer la liste complète des commandes , triée par date de livraison et ordre de création</p>",
    "success": {
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "[\n   {\n       \"Nom du client\": \"ikram\",\n       \"Email\": \"ikram.ahmani@gmail.com\",\n       \"Date de création\": \"2017-02-25 00:00:00\",\n       \"Date de retrait\": \"2017-02-22 18:25:00\",\n       \"Etat\": \"progress\",\n       \"Sandwichs\": [\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": []\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": []\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": []\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": {\n                   \"salades\": \"laitue\",\n                   \"crudités\": \"carottes\",\n                   \"viandes\": \"blanc de poulet\",\n                   \"Fromages\": \"chèvre frais\"\n               }\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": {\n                   \"salades\": \"laitue\",\n                   \"crudités\": \"carottes\",\n                   \"viandes\": \"blanc de poulet\",\n                   \"Fromages\": \"chèvre frais\"\n               }\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": {\n                   \"salades\": \"laitue\",\n                   \"crudités\": \"carottes\",\n                   \"viandes\": \"blanc de poulet\",\n                   \"Fromages\": \"chèvre frais\"\n               }\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": {\n                   \"salades\": \"laitue\",\n                   \"crudités\": \"carottes\",\n                   \"viandes\": \"blanc de poulet\",\n                   \"Fromages\": \"chèvre frais\"\n               }\n           },\n           {\n               \"Taille\": \"petite faim\",\n               \"Type\": \"blanc\",\n               \"ingredients\": {\n                   \"salades\": \"laitue\",\n                   \"crudités\": \"carottes\",\n                   \"viandes\": \"blanc de poulet\",\n                   \"Fromages\": \"chèvre frais\",\n                   \"Sauces\": \"vinaigrette huile d'olive\"\n               }\n           }\n       ]\n   }\n]",
          "type": "json"
        }
      ]
    },
    "filename": "./api.php",
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
    "filename": "./docs/main.js",
    "group": "_home_antoine_Documents_sandwich_www_private_docs_main_js",
    "groupTitle": "_home_antoine_Documents_sandwich_www_private_docs_main_js",
    "name": ""
  }
] });
