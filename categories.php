<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>
<?php

// Import des fonctions
require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php'); 
try {
    // Récupération des abos avec la fonction getAbos() définie dans functions.php
 $cats=getCats();
} catch (Exception $e) {
    // Afficher le message en cas d'envoi d'exception
    echo $e->getMessage();
}

?>

<?php require_once 'head.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='annonces.php' class='btn btn-secondary m-2 active' role='button'>Annonces</a>

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
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Categories</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Nom catégorie</th>
                <th scope='col'>#Categorie Parente</th>
               
            </tr>
        </thead>
        <tbody>
        <!-- <?php affiche_select_cat($cats,"cat",$cat['id_categorie_parente']?? 0); ?> -->
            <?php foreach ($cats as $cat) : ?>
                <tr>
                    <td><?= $cat['id_categorie'] ?></td>
                    <td><?= htmlentities($cat['nom_categorie']) ?></td>
                    <td><?= $cat['id_categorie_parente'] ?></td>
                    <td>
                        <a class='btn btn-primary' href='categories-form.php?id=<?= $cat['id_categorie'] ?>' role='button'>Modifier</a>
                        <a class='btn btn-danger' href='delete-categorie.php?id=<?= $cat['id_categorie'] ?>' role='button' onclick='return confirm("Voulez-vous supprimer?")'>Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        <a class='btn btn-success' href='categories-form.php' role='button'>Ajouter categorie</a>
    </div>
</div>

<?php require_once 'footer.php' ?>
