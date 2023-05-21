# Quai Antique

Ce site a été réalisé dans le cadre de l'évaluation en cours de formation (ECF) au sein de l'organisme de formation Studi.
Il s'agit de concevoir un site pour un restaurant gastronomique en se conformant à une demande détaillée.

Pour déployer le site du restaurant Quai Antique en local:

### Pré-requis
* PHP (version 8.1) avec Composer (gestionnaire de dépendances PHP)
* Extensions PHP :
  * PDO
  * Intl (localisation pour les objets Datetime)
  * Gd (pilote pour la manipulation des images)
* Node.js avec npm ou yarn (gestionnaires de dépendances Javascript)
* MariaDB(version 10.3)
* Git

### Installation
* Depuis le répertoire où vous souhaitez installer le projet, ouvrez un terminal et clonez ce dépôt à l'aide de la commande ```git clone <<adresse>>```, où <<adresse>> sera remplacé selon votre configuration par : 
  * En SSH => git@github.com:Benido/quai-antique.git
  * En https => https://github.com/Benido/quai-antique.git
* Depuis le répertoire du projet, lancez la commande ```composer install``` afin d'installer les dépendances PHP
* Toujours depuis ce répertoire, lancez la commande ```npm install``` afin d'installer les dépendances Javascript
* Dans le fichier .env, ajouter les lignes suivantes : 
  * <span style="font-family:cascadia code">APP_SECRET=3d665533703b33ba74b953f9591fda38</span>
  * <span style="font-family:cascadia code">MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0</span>
  * <span style="font-family:cascadia code">DATABASE_URL="mysql://**votre nom d'utilisateur**:**votre mot de passe**.**votre hôte**:3306/**app**?**version du serveur**&**jeu de caractère**"</span>
    * **votre nom d'utilisateur** : nom d'utilisateur sur le SGBDR
    * **votre mot de passe** : mot de passe du SGBDR
    * **votre hôte** : adresse ip. ex : 127.0.0.1 )
    * **app** : nom de votre application. ex: quai-antique
    * **version du serveur** : disponible sur phpMyadmin ou en tapant mariadb --v dans un terminal. ex: 10.4.24-MariaDB
    * **jeu de caractère** : ex: utf8mb4
* Pour créer la base de données, l'utilisateur **admin** et le schéma des tables, exécuter le fichier 'dumpsql2.sql' situé dans le répertoire <span style="font-family:cascadia code">quai-antique/SQL</span>
* Pour peupler la table de données factices, exécuter le dossier 'populate.sql' situé dans ce même répertoire

### Connexion

Pour se connecter en tant qu'**admin**:
* email : admin@admin.fr
* mot de passe : password