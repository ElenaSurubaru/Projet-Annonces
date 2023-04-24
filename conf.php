<?php
// session_start();
define('TITRE_SITE','GIVE-BUY-SELL');
define('URL_SITE','http://localhost/Projet1/');

define('DEBUG_MODE',true);
define('LIMIT',10);
// Connection à la base de données et renvoie l'objet PDO

require_once('helpers.php');
function connect() {
    // hôte
    $hostname = 'localhost';

    // nom de la base de données
    $dbname = 'projet_annonce';

    // identifiant et mot de passe de connexion à la BDD
    $username = 'root';
    $password = '';
    
    // Création du DSN (data source name) en combinant le type de BDD, l'hôte et le nom de la BDD
    $dsn = "mysql:host=$hostname;dbname=$dbname";

    // Tentative de connexion avec levée d'une exception en cas de problème
    try{
      return new PDO($dsn, $username, $password);
    } catch (Exception $e){
      echo $e->getMessage();
    }
}
?>