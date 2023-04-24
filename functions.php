<?php

require_once('conf.php');
require_once('helpers.php');

function getCatById() {
try {
  $db = connect();
  $catQuery = $db->prepare('SELECT * FROM categories WHERE id_categorie= :id');
  $catQuery->execute(['id' => $id]);
  $cat = $catQuery->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  // Afficher le message s'il y a une exception
  echo $e->getMessage();
 }
}

function getCats() {
    try {
        // Récupération de l'objet PDO
        $db = connect();

        // Requête pour récupérer tous les abos
        $catsQuery=$db->query('SELECT * FROM categories');

        // Renvoie tous les lignes
        return $catsQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // En cas d'erreur afficher le message
        echo $e->getMessage();
    }
}
function addAnnonce() {
  try {
    $db = connect();
  $createannonceStmt = $db->prepare("INSERT INTO `annonces`( `date_creation`, `titre`, `description`, `duree_de_publication_en_mois`, `prix_vente_objet`, `cout_annonce`, `id_mode_paiement`, `id_etat`, `id_utilisateur`) VALUES (:date_creation, :titre, :description, :duree_de_publication_en_mois, :prix_vente_objet, :cout_annonce, :id_mode_paiement, :id_etat, :id_utilisateur)");

  $createannonceStmt->execute(['date_creation'=>$date_creation,'titre'=>$titre, 'description'=>$description, 'duree_de_publication_en_mois'=>$duree_de_publication_en_mois, 'prix_vente_objet'=>$prix_vente_objet,'cout_annonce'=>$cout_annonce, 'id_mode_paiement'=>$id_mode_paiement,'id_etat'=>$id_etat,'id_utilisateur'=>$id_utilisateur]);

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

}
function getAnnonces() {
    try {
        // Récupération de l'objet PDO
        $db = connect();

        // Requête pour récupérer tous les abos
        $annonceQuery=$db->query('SELECT * FROM annonces');

        // Renvoie tous les lignes
        return $annonceQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // En cas d'erreur afficher le message
        echo $e->getMessage();
    }
}

function getAnnonceById($id) {
  try {
      // Récupération de l'objet PDO
      $db = connect();

      // Requête pour récupérer tous les abos
      $annonceQuery=$db->query('SELECT * FROM annonces');

      // Renvoie tous les lignes
      return $annonceQuery->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
      // En cas d'erreur afficher le message
      echo $e->getMessage();
  }
}

function getEtats() {
    try {
        // Récupération de l'objet PDO
        $db = connect();

        // Requête pour récupérer tous les abos
        $abosQuery=$db->query('SELECT * FROM etats');

        // Renvoie tous les lignes
        return $abosQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // En cas d'erreur afficher le message
        echo $e->getMessage();
    }
}

function getEtat($id) {
  try {
      $db = connect();
      $query=$db->prepare('SELECT libelle_etat FROM etats WHERE id_etat= :id');
      $query->execute(['id'=>$id]);
      return $query->fetch();
    } catch(Exception $e){
      if(DEBUG_MODE) echo $e->getMessage();
    }
    return false;
  }


function getPaye() {
    try {
        // Récupération de l'objet PDO
        $db = connect();

        // Requête pour récupérer tous les abos
        $payeQuery=$db->query('SELECT * FROM modes_paiement');

        // Renvoie tous les lignes
        return $payeQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // En cas d'erreur afficher le message
        echo $e->getMessage();
    }
}

  
  
  function Search($recherche){
    try {
      $db = connect();
      $result = $db->prepare("SELECT * FROM annonces WHERE titre LIKE '%$recherche%' OR description LIKE '%$recherche%'");
      $result->execute();
      return $result->fetchAll(PDO::FETCH_ASSOC);

    } catch(Exception $e){
      if(DEBUG_MODE) echo $e->getMessage();
    }
    return false;
  }
  
  
  function addImage($id,$path) {
    $insert=[];
     foreach($path as $k=>$v) {
      try {
        $db=connect();
        $insertImage=$db->prepare("INSERT into photos (id_annonce,url_photo) VALUES (:id_annonce,:url_photo )");
        $req=$insertImage->execute(['id_annonce'=>$id,'url_photo'=>$v]);
        if ($req) $insert[]=$db->lastInsertId();
       } catch (Exception $e) {
          if(DEBUG_MODE) echo $e->getMessage();
        }
      }
        if(!empty ($insert))
        return true;
        else
        return false;
      
   }


   function getImage($id) {
    try {
        $db = connect();
        $query=$db->prepare('SELECT url_photo FROM photos WHERE id_annonce= :id');
        $query->execute(['id'=>$id]);
        if ($query->rowCount()){
            $images=$query->fetchAll(PDO::FETCH_COLUMN,0);
            return $images[random_int(0,count($images)-1)];
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } 
    return false;
}



  