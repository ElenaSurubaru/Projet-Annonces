
<?php
 session_start();
 require_once('conf.php');
 require_once('helpers.php');
 require_once('functions.php'); 
 require_once('functions-users.php'); 
 if(isset($_SESSION['admin'])){
  $user = $_SESSION['admin'];
 }else{

 }

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    try {
        // Se connecter à la BDD avec la fonction connect() définie dans functions.php
        $db = connect();

        // Préparer $annonceQuery pour récupérer les informations du membre
        $annonceQuery = $db->prepare('SELECT * FROM annonces WHERE id_annonce= :id');
        // Exécuter la requête
        $annonceQuery->execute(['id' => $id]);
        // Récupérer les données et les assigner à $annonce
        $annonce = $annonceQuery->fetch(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }
    // Fermer la connection à la BDD
    $annonceQuery=null;
    $db=null;
}        
$cats = getCats();
$etats=getEtats();
$payements=getPaye(); 
$cout_annonce=10;
?>
<?php require_once 'head.php' ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/contact.css" />
        <title> Ajout Annonce</title>
    </head>  
    <body>    
    <a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
     <a href='annonces.php' class='btn btn-secondary m-2 active' role='button'>Annonces</a>
       <div class="categories">
            <h1>Ajouter/Modifier une annonce</h1>
            <form method='post' action='add-edit-annonce.php' enctype="multipart/form-data">
        <!--  Ajouter the ID to the form if it exists but make the field hidden -->
        <input type='hidden' name='id' value='<?= $annonce['id_annonce'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='Titre'>Titre</label>
            <input type='text' name='titre' class='form-control' id='titre' placeholder='Titre' required autofocus value='<?= isset($annonce['titre']) ? htmlentities($annonce['titre']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='description'>Description annonce</label>
            <textarea name='description' class='form-control' id='description' placeholder='description ' required ><?= isset($annonce['description']) ? htmlentities($annonce['description']) : '' ?></textarea>
        </div>
        <div class='form-group my-3'>
            <label for='duree_de_publication_en_mois'>Durée de publication en mois</label>
            <input type='number' name='duree_de_publication_en_mois' class='form-control' id='duree_de_publication_en_mois' min="1" placeholder='Durée de publication en mois' required  autofocus value='<?= isset($annonce['duree_de_publication_en_mois']) ? htmlentities($annonce['duree_de_publication_en_mois']) : '' ?>'><br><hr><br>
            
            <label for="cat">Catégorie</label><br>
            <?php affiche_select_cat($cats,"cat",$cat['id_categorie_parente']?? 0); ?>
            <br>
           
            <label for='prix_vente_objet'>Prix vente objet</label>
            <input type="text" id="prix_vente_objet" name="prix_vente_objet" placeholder="Prix vente objet" min="1" required autofocus value='<?= isset($annonce['prix_vente_objet']) ? htmlentities($annonce['prix_vente_objet']) : '' ?>'><br><hr>
             
            <p>Indiquez l'état de l'article<br>
             <?php affiche_select_etat($etats,"id_etat",$etat['id_etat']?? 0); ?>
		
            <br>
             
            <p>Indiquez le mode de paiement<br>
            <?php affiche_select_paye($payements,"id_mode_paiement",$paye['id_mode_paiement']?? 0); ?>
                
            <label for ="file">Ajouter des images</label>
            <input type="file" id="image" name="image[]" placeholder="Photo" multiple accept="image/*"><br><br>

            <input type="submit" name="submit"value="Ajouter" class="submit">      
        </form>
<br>
<hr>
<footer>
    <div class="menu">
        <div class="accueil_footer">
            <a href="index.php">
            <i class="fas fa-home"></i>
            <p>Accueil</p>
        </a>
</div>
</footer>
<script src="https://kit.fontawesome.com/508ebce8fc.js"></script> 
</body>
</html>