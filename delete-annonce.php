<?php
require_once('conf.php');
require_once('helpers.php');
require_once('functions.php'); 
require_once('functions-users.php'); 

// L'ID est-il dans les paramètres d'URL?
if (isset($_GET['id'])) {
    // Récupérer $id depuis l'URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    try {
        // Connection à la BDD avec la fonction connect() dans functions.php
        $db = connect();
        // Préparation de la requête pour supprimer le annonce correspondant à l'id
        $deleteannonceStmt = $db->prepare('DELETE FROM annonces WHERE id_annonce=:id');
        // Execution de la requête
        $deleteannonceStmt->execute(['id' => $id]);
        // Vérification qu'une ligne a été impactée avec rowCount()
        if ($deleteannonceStmt->rowCount()) {
            // La ligne a été détruite, on envoie un message de succès
            $type = 'success';
            $message = 'annonce supprimé';
        } else {
            // Aucune ligne n'a été impactée, on envoie un message d'erreur
            $type = 'error';
            $message = 'annonce non supprimé';
        }
    } catch (Exception $e) {
        // Une exception a été levée, on affiche le message d'erreur
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    // Fermeture de la connexion à la BDD
    $deleteannonceStmt = null;
    $db = null;
    // Redirection vers la page principale des annonces en passant le message et son type en variables GET
    header('location:' . 'annonces.php?type=' . $type . '&message=' . $message);
} else {
    //Redirection vers l'Accueil s'il n'y a pas d'ID annonce 
    header('location:'. 'index.php');
}
?>