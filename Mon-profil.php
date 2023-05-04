
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'> 
    <link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/styleidentifier.css" />

    <title>Give-buy-sell </title>
</head>

<body>

    <header>
        <a href="index.php"><h1>Give-buy-sell</h1></a>
     <?php   require_once 'head.php'; 
             require_once('conf.php');
             require_once('helpers.php');
             require_once('functions.php'); 
             require_once('functions-users.php');
            ?>


    </header>
  <h2> Mon profil </h2>
    <?php
    $db=connect();
    session_start();
    login();
    if (!isset($_SESSION["login"])) {
        header("Location: identifier-form.php");
        exit();
    }
$user_id = $_SESSION["id_utilisateur"];

// requête pour récupérer les annonces de l'utilisateur
$stmt = $db->prepare("SELECT * FROM annonces WHERE id_utilisateur = :id_utilisateur");
// $stmt->bindParam(':id_utilisateur', $user_id, PDO::PARAM_INT);
$stmt->execute(['id_utilisateur'=>$user_id]);
$annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<br>Bonjour ".$_SESSION['login'].", vous êtes en ligne";
?>

<?php require_once 'head.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='annonces.php' class='btn btn-secondary m-2 active' role='button'>Annonces</a>
<a href='mon-compte-user.php' class='btn btn-secondary m-2 active' role='button'>Mes Données personnelles</a>

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
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Mes Annonces</h1>
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
        <a class='btn btn-success' href='annonce-form.php' role='button'>Ajouter annonce</a>
    </div>
</div>

<?php require_once 'footer.php' ?>
    <hr>
    <a href="disconnect.php"><button id="ajouter" style="background-color: red;">Déconnexion</button></a>
    </div>
    
   
</body>
</html>