<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/styleidentifier.css" />
<?php
require_once('conf.php');
require_once('helpers.php');
require_once('functions.php'); 
require_once('functions-users.php'); 

$results=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$recherche = htmlentities($_POST['recherche']);
$results=Search($recherche);
}

?>
<?php require_once 'head.php' ?>
<div class='row'>
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Resultats recherche</h1>
</div>
<div class='row'>
   
      
            <div class="flex-container">
            
            <?php
                if(!$results) {
                    echo "<p>Pas de resultat</p>";
                }
                else {
               foreach ($results as $annonce) :
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
    
                
            <?php endforeach; 
            }?>
            </div>
</div>

