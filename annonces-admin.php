<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'> 
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php

require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php'); 

// Création d'un bloc try/catch pour gérer les exceptions de la BDD
try {
    // Connection à la BDD
    $db = connect();
   $annoncesQuery = $db->query('SELECT * FROM annonces ');
   // Récupération de tous les membres et assignation à $members
    $annonces = $annoncesQuery->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    // Affiche le message en cas d'exception
    echo $e->getMessage();
}

// Fermeture de la connexion à la BDD
$db=null;
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
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Annonces</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Date_creation</th>
                <th scope='col'>Titre</th>
                <th scope='col'>Description</th>
                <th scope='col'>duree_de_publication_en_mois</th>
                <th scope='col'>prix_vente_objet</th>
                <th scope='col'>cout_annonce</th>
                <th scope='col'>date_validation</th>
                <th scope='col'>date_fin_publication</th>
                <th scope='col'>#modepaiement</th>
                <th scope='col'>#etat</th>
                <th scope='col'>#utilisateur</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($annonces as $annonce) : ?>
                <tr>
                    <td><?= $annonce['id_annonce'] ?></td>
                    <td><?= htmlentities($annonce['date_creation']) ?></td>
                    <td><?= htmlentities($annonce['titre']) ?></td>
                    <td><?= htmlentities($annonce['description']) ?></td>
                    <td><?= htmlentities($annonce['duree_de_publication_en_mois']) ?></td>
                    <td><?= htmlentities($annonce['prix_vente_objet']) ?></td>
                    <td><?= htmlentities($annonce['cout_annonce']) ?></td>
                   <!-- <td><?= htmlentities(date("d/m/Y",strtotime($annonce['date_validation']))) ?>
                   <td><?= htmlentities($annonce['date_fin_publication']) ?> -->
                    <td><?= htmlentities($annonce['id_mode_paiement']) ?></td>
                    <td><?= htmlentities($annonce['id_etat']) ?></td>
                    <td><?= htmlentities($annonce['id_utilisateur']) ?></td>
                    <td>
                         <a class='btn btn-primary' href='annonce-form.php?id=<?= $annonce['id_annonce'] ?>' role='button'>Modifier</a> 
                       <a class='btn btn-danger' href='delete-annonce.php?id=<?= $annonce['id_annonce'] ?>' role='button' onclick='return confirm("Voulez-vous supprimer?")'>Supprimer</a> 
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
     
    </div>
</div>

<?php require_once 'footer.php' ?>