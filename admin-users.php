
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'> 
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php

require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php'); 

$users=getUsers($limit=10,$page=1);
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
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Mon compte admin</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Login</th>
                <th scope='col'>Email</th>
                <th scope='col'>Mot de passe</th>
                <th scope='col'>Nom</th>
                <th scope='col'>Prénom</th>
                <th scope='col'>Date_naissance</th>
                <th scope='col'>Num_telephone</th>
                <th scope='col'>Sexe</th>
                <th scope='col'>Adresse_postale</th>
                <th scope='col'>Code_postal</th>
                <th scope='col'>Ville</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user['id_utilisateur'] ?></td>
                    <td><?= htmlentities($user['login']) ?></td>
                    <td><?= htmlentities($user['email']) ?></td>
                    <td><a href="reset-password.php">Modifier mon mot de passe</a>
                    <td><?= htmlentities($user['nom_utilisateur']) ?></td>
                    <td><?= htmlentities($user['prenom_utilisateur']) ?></td>
                    <td><?= htmlentities($user['date_naissance']) ?></td>
                    <td><?= htmlentities(($user['num_telephone'])) ?>
                    <td><?= htmlentities($user['sexe']) ?>
                    <td><?= htmlentities($user['adresse_postale']) ?></td>
                    <td><?= htmlentities($user['code_postal']) ?></td>
                    <td><?= htmlentities($user['ville']) ?></td>
                    <td>
                         <a class='btn btn-primary' href='Mon-profil.php?id=<?= $user['id_utilisateur'] ?>' role='button'>Modifier</a> 
                       <a class='btn btn-danger' href='delete-user.php?id=<?= $user['id_utilisateur'] ?>' role='button' onclick='return confirm("Voulez-vous supprimer?")'>Supprimer votre compte</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        <a class='btn btn-success' href='identifier-form.php' role='button'>Ajouter annonce</a>
    </div>
</div>

<?php require_once 'footer.php' ?>