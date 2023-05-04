<link rel="stylesheet" media="screen" type="text/css" title="Design" href="styleidentifier.css" />
<?php
session_start();
// Import des fonctions
require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php');   

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $safe_email=filter_var(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL);
       if($safe_email) {
         $db=connect();
         $query=$db->prepare('SELECT email FROM utilisateur Where email=:email');
         $query->execute(['email'=>$safe_email]);
         if(!$query->rowCount())   {
             $pwd=htmlspecialchars($_POST['password']);
             $pwd2=htmlspecialchars($_POST['password']);
              if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?+&]).{8,}$/',$pwd)) {   
                if($pwd===$pwd2) {
                   if(isset($_SESSION['id_utilisateur'])) {
                    updateUser($_SESSION['id_utilisateur']);
                   }
                   else {
                    adduser();
                   }
                    echo "Enregistrement réussi";
                    header("location:Mon-profil.php ");  
                }
                else {
                    echo "Probléme lors de l'enregistrement";
                }
              } else {
                echo "Le mot de passe doit contenir 8 caractéres avec 1 minuscule, 1 majuscule et 1 caractere(&%+/$)";
            
                 }
    
         }else {
            echo "L'email existe deja";
          
             }
    }              else {
        echo "Mail non valide";
        header("location:index.php? ");  
        
               }
    }
    if (isset($_SESSION['id_utilisateur'])) {
        $user=getUtilisateur($_SESSION['id_utilisateur']);
        // récupérer $id dans les paramètres d'URL
    }
?>
<?php require_once 'head.php' ?>
<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='annonces.php' class='btn btn-secondary m-2 active' role='button'>Annonces</a>
<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Créer un compte</h1>
</div>
<div class='row'>
    <form method='post' action=''>
        <div class='form-group my-3'>
        <input type='hidden' name='id' value='<?= $user['id'] ?? '' ?>'>
        <label for="login"> Login : </label>
        <input type="text" id="login" name="login" placeholder="Login" min="8" required autofocus value='<?= isset($user['login']) ? htmlentities($user['login']) : '' ?>'><br>
        <label for="email">Email:</label>
<input type="email" name="email" placeholder="Votre email" required  value='<?= isset($user['email']) ? htmlentities($user['email']) : '' ?>'><br>
<label for="password">Mot de passe:</label>
<input type="password" name="password" placeholder="Votre mot de passe" required  value='<?= isset($user['password_hash']) ? htmlentities($user['password_hash']) : '' ?>'><br>
<label for="password">Retapez votre mot de passe:</label>
<input type="password" name="password" placeholder="retapez votre mot de passe" required  value='<?= isset($user['password_hash']) ? htmlentities($user['password_hash']) : '' ?>'><br>
<label for="nom">Nom:</label>
<input type="text" name="nom" placeholder="Votre nom" required  value='<?= isset($user['nom_utilisateur']) ? htmlentities($user['nom_utilisateur']) : '' ?>'><br>
<label for="nom">Votre prénom:</label>
<input type="text" name="prenom" placeholder="Votre prénom" required value='<?= isset($user['prenom_utilisateur']) ? htmlentities($user['prenom_utilisateur']) : '' ?>'><br>
<label for="date_naissance">Date de naissance:</label>
<input type="date" name="date_naissance" placeholder="Date de naissance sous le format jj//mm//aaaa" required value='<?= isset($user['date_naissance']) ? htmlentities($user['date_naissance']) : '' ?>'><br>
<label for="num_telephone">Numéro de téléphone:</label>
<input type="text" name="num_telephone" placeholder="Numéro de téléphone sous le format 06..." required  value='<?= isset($user['num_telephone']) ? htmlentities($user['num_telephone']) : '' ?>'><br>
<label for="sexe">Votre sexe:</label>
</div>
<div class="select">
 <select name="sexe">
     <option value="1" <?php if(isset($user['sexe']) && $user['sexe'] == 1) echo 'selected'; ?>>Femme</option>
     <option value="0" <?php if(isset($user['sexe']) && $user['sexe'] == 0) echo 'selected'; ?>>Homme</option>
  </select><br>
</div>
     <label for="adresse_postale">Adresse:</label>
     <div class="textarea">
		<Textarea name="adresse_postale" id="adresse_postale" rows="5" max lenght="255" cols="10" placeholder="adresse" <?= isset($user['adresse_postale']) ? htmlentities($user['adresse_postale']) : '' ?>>Adresse</textarea>
<br>
<div>
<label for="code_postal">Code postal:</label>
<input type="code_postal" name="code_postal" placeholder="Code postal" required value='<?= isset($user['code_postal']) ? htmlentities($user['code_postal']) : '' ?>'><br>
<label for="ville">Ville:</label>
<input type="ville" name="ville" placeholder="Ville" required value='<?= isset($user['ville']) ? htmlentities($user['ville']) : '' ?>'><br>
        </div>
        <div class='form-group my-3'>      
        </div>
        <button type='submit' class='btn btn-primary my-3' name='submit'>Submit</button>
    </form>
</div>

<?php require_once 'footer.php' ?>
