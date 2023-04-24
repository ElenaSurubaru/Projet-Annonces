<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>
<?php

require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php'); 

if (!empty($_POST)) {
   
    
    $nom = $_POST['nom_categorie'] ?? '';
    $cat_id = filter_input(INPUT_POST, 'cat', FILTER_SANITIZE_NUMBER_INT);

    // Connection à la BDD avec la fonction connect() dans functions.php
    $db = connect();

    // Un membre n'a un ID que si ses infos sont déjà enregistrées en BDD, donc on vérifie s'il  le membre a un ID.
    if (empty($_POST['id'])) {
         // S'il n'y a pas d'ID, le membre n'existe pas dans la BDD donc on l'ajoute.
         try {
            // Préparation de la requête d'insertion.
            $createCatStmt = $db->prepare('INSERT INTO categories (nom_categorie, id_categorie_parente ) VALUES ( :nom_categorie, :id_categorie_parente)');
            // Exécution de la requête
            $createCatStmt->execute(['nom_categorie'=>$nom, 'id_categorie_parente'=>$cat_id]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($createCatStmt->rowCount()) {
                // Une ligne a été insérée => message de succès
                $type = 'success';
                $message = 'Categorie ajouté';
            } else {
                // Aucune ligne n'a été insérée => message d'erreur
                $type = 'error';
                $message = 'Categorie non ajouté';
            }
        } catch (Exception $e) {
            // Le membre n'a pas été ajouté, récupération du message de l'exception
            $type = 'error';
            $message = 'Categorie non ajouté: ' . $e->getMessage();
        }
    } else {
        // Le membre existe, on met à jour ses informations

        // Récupération de l'ID du membre
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        // Mise à jour des informations du membre
        try {
            // Préparation de la requête de mis à jour
            $updateCatStmt = $db->prepare('UPDATE categories SET nom_categorie=:nom_categorie,  id_categorie_parente=:id_categorie_parente WHERE id_categorie=:id_categorie');
            // Exécution de la requête
           $updateCatStmt->execute(['nom_categorie'=>$nom, 'id_categorie'=>$id, 'id_categorie_parente'=>$cat_id]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($updateCatStmt->rowCount()) {
                // Une ligne a été mise à jour => message de succès
                $type = 'success';
                $message = 'Categorie mis à jour';
            } else {
                // Aucune ligne n'a été mise à jour => message d'erreur
                $type = 'error';
                $message = 'Categorie non mis à jour';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'Categorie non mis à jour: ' . $e->getMessage();
        }
    }

    // Fermeture des connexions à la BDD
    $updateCatStmt = null;
    $updateCatStmt = null;
    $db = null;

    // Redirection vers la page principale des membres en passant le message et son type en variables GET
    header('location:' . 'categories.php?type=' . $type . '&message=' . $message);
}