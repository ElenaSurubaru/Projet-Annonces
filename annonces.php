<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'> 
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/styleidentifier.css" />
<?php
session_start();
require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php'); 

$annonces=getAnnonces();
?>

<?php require_once 'head.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='annonces.php' class='btn btn-secondary m-2 active' role='button'>Annonces</a>
<a href='Mon-profil.php' class='btn btn-secondary m-2 active' role='button'>Mon-profil</a>

<?php if (!empty($_GET['type']) && ($_GET['type'] === 'success')) : ?>
    <div class='row'>
        <div class='alert alert-success'>
            Succès! <?= $_GET['message'] ?>
        </div>
    </div>
<?php elseif (!empty($_GET['type']) && ($_GET['type'] === 'error')) : ?>
    <div class='row'>
        <div class='alert alert-danger'>
            Erreur! <?= $_GET['message'] ?>
        </div>
    </div>
<?php endif; ?>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Annonces</h1>
</div>
<div class='row'>
   
      
            <div class="flex-container">
            
            <?php foreach ($annonces as $annonce) :
               $utilisateur= getUtilisateur($annonce['id_utilisateur']);
               $etat=getEtat($annonce['id_etat']);
                ?>
              
                <div class="flex-items">
                 <p><img src="<?= getImage($annonce['id_annonce'])?? 'img/defaut.jpg'?>" width="300px" alt="Photo"></p>                  
                    <p>Date de création:<?= htmlentities($annonce['date_creation']) ?></p>
                    <p>Titre:<?= htmlentities($annonce['titre']) ?></p>
                    <p>Description:<?= htmlentities($annonce['description']) ?></p>
                    <p>Prix de vente:<?= htmlentities($annonce['prix_vente_objet']) ?></p>
                    <p>Etat:<?= htmlentities($etat['libelle_etat']) ?></p>
                    <p>Utilisateur:<?= htmlentities($utilisateur['nom_utilisateur']) ?></p>
                    
                   
                    </div>
    
                
            <?php endforeach; ?>
            </div>
</div>
          <?php if (isset($_SESSION['connected'])){
            ?>
<div class='row'>
    <div class='col'>
        
        <a class='btn btn-success' href='annonce-form.php' role='button'>Créer une annonce</a>
    </div>
</div>
   <?php } ?>
<?php require_once 'footer.php' ?>