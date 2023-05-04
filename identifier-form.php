<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/styleidentifier.css" />
</head>
<body>
<h1>GIVE-BUY-SELL</h1>
<h2>Bonjour !
  Connectez-vous pour découvrir toutes nos fonctionnalités.</h2>
  <?php
  session_start();
// Import des fonctions
require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php'); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if(login()) {
      echo 'Bienvenue!';
   }
  else echo '<p>Mauvais identifiants</p>';
  } 
$users = getUsers();

?>

<form action="Mon-profil.php" method="post">
  <div class="imgcontainer">
    
  </div>

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="login" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
        
    <button type="submit" >Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="forgot.php">password?</a></span>
  </div>
  <small>Envie de nous rejoindre ?</small> 

  <a href="creationcompte-form.php" class="w3-bar-item w3-button">Créer un compte</a>


</form>

</body>
</html>