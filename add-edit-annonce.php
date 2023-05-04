<?php
session_start();
  require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php'); 

if (!empty($_POST)) {
    $date_creation=date("Y-m-d");
    $titre =strip_tags($_POST['titre'] ?? '');
    $description = strip_tags($_POST['description'] ?? '');
    $duree_de_publication_en_mois = strip_tags($_POST['duree_de_publication_en_mois'] ?? '');
    $prix_vente_objet = strip_tags($_POST['prix_vente_objet'] ?? '');
    $id_mode_paiement =strip_tags($_POST['id_mode_paiement'] ?? '');
    $cout_annonce = 10;
    $id_etat = strip_tags($_POST['id_etat'] ?? '');
    $id_utilisateur = $_SESSION['id_utilisateur'] ?? '';
   

    if(isset($_FILES['image'])){
        $path=[];
        foreach($_FILES['image']['error'] as $k=>$v){
            if(is_uploaded_file($_FILES['image']['tmp_name'][$k]) && $_FILES['image']['error'][$k] == UPLOAD_ERR_OK) {
                $path[$k]="img/".$_FILES['image']['name'][$k];
                move_uploaded_file($_FILES['image']['tmp_name'][$k],$path[$k]);
            }
        }}
    $db = connect();

    // Un annonce n'a un ID que si ses infos sont déjà enregistrées en BDD, donc on vérifie s'il  le annonce a un ID.
    if (empty($_POST['id'])) {
         // S'il n'y a pas d'ID, le annonce n'existe pas dans la BDD donc on l'ajoute.
         try {
            // Préparation de la requête d'insertion.
            $createannonceStmt = $db->prepare("INSERT INTO `annonces`( `date_creation`, `titre`, `description`, `duree_de_publication_en_mois`, `prix_vente_objet`, `cout_annonce`, `id_mode_paiement`, `id_etat`, `id_utilisateur`) VALUES (:date_creation, :titre, :description, :duree_de_publication_en_mois, :prix_vente_objet, :cout_annonce, :id_mode_paiement, :id_etat, :id_utilisateur)");
            // Exécution de la requête
            $createannonceStmt->execute(['date_creation'=>$date_creation,'titre'=>$titre, 'description'=>$description, 'duree_de_publication_en_mois'=>$duree_de_publication_en_mois, 'prix_vente_objet'=>$prix_vente_objet,'cout_annonce'=>$cout_annonce, 'id_mode_paiement'=>$id_mode_paiement,'id_etat'=>$id_etat,'id_utilisateur'=>$id_utilisateur]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($createannonceStmt->rowCount()) {
                $last_id=$db->lastInsertId();
                addImage($last_id,$path);
                // Une ligne a été insérée => message de succès
                $type = 'success';
                $message = 'annonce ajouté';
            } else {
                // Aucune ligne n'a été insérée => message d'erreur
                $type = 'error';
                $message = 'annonce non ajouté';
            }
        } catch (Exception $e) {
            // Le annonce n'a pas été ajouté, récupération du message de l'exception
            $type = 'error';
            $message = 'annonce non ajouté: ' . $e->getMessage();
        }
    } else {
        // Le annonce existe, on met à jour ses informations

        // Récupération de l'ID du annonce
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        // Mise à jour des informations du annonce
        try {
            // Préparation de la requête de mis à jour
            $updateannonceStmt = $db->prepare("UPDATE annonces SET date_creation=:date_creation,titre=:titre,description=:description,duree_de_publication_en_mois=:duree_de_publication_en_mois,prix_vente_objet=:prix_vente_objet,cout_annonce=:cout_annonce,id_mode_paiement=:id_mode_paiement,id_etat=:id_etat,id_utilisateur=:id_utilisateur WHERE id_annonce=:id");
            // Exécution de la requête
           $updateannonceStmt->execute(['date_creation'=>$date_creation, 'titre'=>$titre, 'description'=>$description, 'duree_de_publication_en_mois'=>$duree_de_publication_en_mois,'prix_vente_objet'=>$prix_vente_objet,'cout_annonce'=>$cout_annonce,'id_mode_paiement'=>$id_mode_paiement,'id_etat'=>$id_etat,'id_utilisateur'=>$id_utilisateur,'id'=>$id]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($updateannonceStmt->rowCount()) {
                // Une ligne a été mise à jour => message de succès
                $type = 'success';
                $message = 'annonce mis à jour';
            } else {
                // Aucune ligne n'a été mise à jour => message d'erreur
                $type = 'error';
                $message = 'annonce non mis à jour';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'annonce non mis à jour: ' . $e->getMessage();
        }
    }

    // Fermeture des connexions à la BDD
    $createannonceStmt = null;
    $updateannonceStmt = null;
    $db = null;

    // Redirection vers la page principale des annonces en passant le message et son type en variables GET
    header('location:' . 'annonces.php?type=' . $type . '&message=' . $message);
}
?>