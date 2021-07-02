## Smart Tribune - Backend - Coding Test :

**Clonage du mini projet**
git clone https://github.com/gvandencruche/smartTribune.git

L'archive contient :
sources : dossier du projet symfony
docker : dossier de l'image docker
postman.pdf : test postman de l'API 
fixture.json : Données de départ de l'analyse


**Analyse :**
*constat de départ*
La fixture de départ contient un tableau de json pour la valeur answers.
Je suis donc parti du constat que la FAQ (Question) pouvait etre ratachée à plusieurs réponses publiées ou non.

*La structure de donnée de la base est donc :*
Une entity FAQ contenant le titre, le promoted, la date de creation, de modification  et le status de la question
Une entity AnswersFAQ contenant un body de la reponse et le channel
Une entity HistoricFaq contenant la trace des modifications des Faq



**Initialisation de l'environement de dev docker :**
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


##### Ajout FAQ:

Création d'une API POST d'ajout de FAQ (FAQ/add) se basant sur 3 entity :
FAQ (table des questions)
AnswersFAQ (table des réponses au questions)
HistoricFaq (table de l'historisation des modifications des FAQ title ou status)

Les types enum sont gérés par Doctrine en definissant des classes de mappage spécifiques pour channel et status
Les valeurs requises sont definies dans les classes : 
DBA/Types/AnswersChannelFAQType.php et DBA/Types/StatusFAQType.php
Toutes modifications des constantes definies doit faire etre synchronisées avec la base (par un doctrine:migrations:diff puis doctrine:migrations:execute ...)

*Test de l'API :*
Cette API prend comme argument d'entré un json (voir doucument Postman.odt)
Le test unitaire tests/FAQTest.php est configuré pour tester l'API.


##### Modification FAQ:

*Modification d'une FAQ : *
Création d'une API POST de modification des FAQ (FAQ/update)
Le json passé en Post prend en compte l'identifiant
exemple json pour modifier le title et le status de la faq 1 :
{
    "id": "1",
    "title": "question 10",
    "status": "published"
}

##### Service export CSV:

Non terminé.
Le choix de la relation FAQ/AnswersFAQ ne m'a pas permis de réaliser dans les temps la classe d'exportation générique des Entity en CSV.
TODO dans la classe FAQRepository.php
