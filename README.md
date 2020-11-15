<h1 align="center">Exercice MentalWorks</h1>

## Context

Ce projet permet de gérer l'administration via un CRUD de client et de leurs sites web accéssible à partir du dashboard de EasyAdmin, il affiche aussi via une pagination 15 sites web par pages sous forme de card référancé sur la plateforme ainsi que leurs informations, une barre de recherche et présente sur l'accueil du site et permet de faire une recherche soit par le nom du site soit par le nom du client.
Une Icone est présente et permet de traduire l'ensemble du site du français en anglais.  

## Technologies utilisée :

Symfony version: 5.1.8, bootstrap CDN, EasyAdmin, KNP paginator

## 🚀 Usage
Télecharger le projet, installer les dépendance suivantes :

dépendances utilisées :

composer require admin knplabs/knp-paginator-bundle
--dev orm-fixtures knplabs/knp-paginator-bundle symfony/translator --dev fzaninotto/faker

executer commandes suivantes :

composer update
créer .env
database Myslq
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

Se connecter avec les identifiant suivant :

EMAIL:
test@test.com

PASSWORD:
password

## Author

👤 **Mebarki Yamine**


