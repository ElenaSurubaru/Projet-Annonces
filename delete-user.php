<?php
require_once('conf.php');
require_once('helpers.php');
require_once('functions.php'); 
require_once('functions-users.php'); 
if (isset($_GET['id'])) {

    // Récupérer $id depuis l'URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
     deleteUser($_GET['id']);
     if (deleteUser($_GET['id'])) {
        // La ligne a été détruite, on envoie un message de succès
        $type = 'success';
        $message = 'Compte supprimé';
    } else {
        // Aucune ligne n'a été impactée, on envoie un message d'erreur
        $type = 'error';
        $message = 'Compte non supprimé';
    }
// Redirection vers la page principale des annonces en passant le message et son type en variables GET
header('location:' . 'annonces.php?type=' . $type . '&message=' . $message);
} else {
//Redirection vers l'Accueil s'il n'y a pas d'ID annonce 
header('location:'. 'index.php');
}
session_destroy();
?>