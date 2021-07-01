## Smart Tribune - Backend - Coding Test :


**Environement de dev docker :**
*Lancement de l'image docker :*
Dans le dossier parent du projet symfony lancer docker compose afin de créer et démarer les containers :
docker-compose -d --build 

Ensuite, il faut se connecter au container smartTribune_docker-server et initialiser la base de données :
docker exec -it smartTribune_docker-server /bin/bash


les Api sont accessibles avec l'url http://localhost/8101
la base de donnée accessible via phpMyadmin via l'url http://localhost/8102


*Création database :*
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate -n


**Environnement de test (PHPUnit)**
*Création database de test :*
APP_ENV=test symfony console doctrine:database:create
APP_ENV=test symfony console doctrine:migrations:migrate -n

*Lancement des tests :*
Un test créé sur l'ajout d'une FAQ
phpunit (vendor/phpunit/phpunit)


##### Step 1:

Création d'une API POST d'ajout de FAQ (FAQ/add) se basant sur 3 entity :
FAQ (table des questions)
AnswersFAQ (table des réponses au questions)

Les types enum sont gérés par Doctrine en definissant des classes de mappage spécifiques pour channel et status
Les valeurs requises sont definies dans les classes : 
DBA/Types/AnswersChannelFAQType.php et DBA/Types/StatusFAQType.php
Toutes modifications des constantes definies doit faire etre synchronisées avec la base (par un doctrine:migrations:diff puis doctrine:migrations:execute ...)

*Test de l'API :*
Cette API prend comme argument d'entré un json (voir doucument Postman.odt)
Le test unitaire tests/FAQTest.php est configuré pour tester l'API.


##### Step 2:

*Modification d'une FAQ : *
Création d'une API POST de modification des FAQ (FAQ/update)
Le json passé en Post prend en compte l'identifiant
exemple json pour modifier le title et le status de la faq 1 :
{
    "id": "1",
    "title": "question 10",
    "status": "published"
}

##### Step 3:

1. Create an exporter service which is be able to export any entity type content into CSV file
2. Use the previously created exporter in order to export HistoricQuestion datas

##### Bonus:

1. Dockerize the project and provide related readme file 
2. Explain how you would do it if you've been asked to populate HistoricQuestion asynchronously
