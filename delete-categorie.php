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

            // Préparation de la requête pour supprimer l'cat correspondant à l'id
            $deletecatStmt = $db->prepare('DELETE FROM categories WHERE id_categorie=:id');
            // Execution de la requête
            $deletecatStmt->execute(['id' => $id]);
            // Vérification qu'une ligne a été impactée avec rowCount()
            if ($deletecatStmt->rowCount()) {
                // La ligne a été détruite, on envoie un message de succès
                $type = 'success';
                $message = 'catégorie supprimé';
            } else {
                // Aucune ligne n'a été impactée, on envoie un message d'erreur
                $type = 'error';
                $message = 'catégorie non supprimé';
            }
         
    } catch (Exception $e) {
        // Une exception a été levée, on affiche le message d'erreur
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    // Fermeture de la connexion à la BDD
    
    $deletecatStmt = null;
    $db = null;

    // Redirection vers la page principale des cats en passant le message et son type en variables GET
    header('location:' . 'categories.php?type=' . $type . '&message=' . $message);
 } else {
    //Redirection vers l'Accueil
    header('location:' . 'index.php');
}
?>