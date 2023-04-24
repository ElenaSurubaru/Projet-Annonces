<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/styleidentifier.css" />
<?php

// Import des fonctions
require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php'); 

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
}
$cats = getCats();

?>
<?php require_once 'head.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='categories.php' class='btn btn-secondary m-2 active' role='button'>Categories</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Categories Form</h1>
</div>
<div class='row'>
    <form method='post' action='add-edit-categorie.php'>
        <!--  Ajouter un champs cacher avec l'ID (s'il existe) pour qu'il soit envoyé avec le formulaire -->
        <input type='hidden' name='id' value='<?= $cat['id_categorie'] ?? '' ?>'>
        <div class='form-group my-3'>
             <label for="nom_categorie">Créer une catégorie/sous-catégorie</label>
            <input type='text' name='nom_categorie' class='form-control' id='titre' placeholder='Nom categorie' required autofocus value='<?= isset($cat['nom_categorie']) ? htmlentities($cat['nom_categorie']) : '' ?>'>
        </div>
        <p>Catégorie parente</p>
         <?php affiche_select_cat($cats,"cat",$cat['id_categorie_parente']?? 0); ?>
        <button type='submit' class='btn btn-primary my-3' name='submit'>Envoyer</button>
    </form>
</div>

<?php require_once ('footer.php'); ?>