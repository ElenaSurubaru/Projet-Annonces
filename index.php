<?php
if(!isset($_SESSION)) {
	 session_start();
  }
  require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php'); 

	 ?>
<!DOCTYPE html>
<html lang="fr">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true) {
	include ('admin.php');
} 
   else { ?>
	
	<?php include "head.php";?>

	<?php include "menu.php";?>
<br>
<body>

<div id="main">
<div class='row'>
 

<div id="column_left">
<br><br><br><br><h2>Catégories</h2>
<ul>
	 <?php
	
	 $cats=getcats();
	 foreach (getcats() as $cat) {
	 echo '<li><a href="annonces.php"? cat='.$cat["id_categorie"].'>'.$cat["nom_categorie"].'</a></li>';
	 }
	 ?>

</ul>
</div><?php

if(isset($_GET['logout']) && $_GET['logout'] && is_connected()) {
  logout();
  echo '<script>alert("Vous etes déconnecté");</script>';
}?>
<br><br><br><br>
<div id="column_right">
<ul>
    <?php if(!is_connected()) { ?>
	<li><a href ="<?=URL_SITE;?>identifier-form.php"> Je m'identifie </a></li>
	<li><a href="<?=URL_SITE;?>creationcompte-form.php"> Je crée un compte </a> (nécessaire pour déposer une annonce)</li>
	<li><a href="<?=URL_SITE;?>forgot.php"> Mot de passe oublié </a></li>
	<?php } else { ?>
	<li><a href ="<?=URL_SITE;?>Mon-profil.php"> Mon profil </a></li>
	<li><a href="<?=URL_SITE;?>?logout=true">Se déconnecter</a></li>
      <?php } ?>
</ul>
</div><?php 
// Vérifier si l'utilisateur est administrateur

if(empty($_GET['p']))  include('home.php');
 elseif(!is_connected() && $_GET['p']=='login') include('identifier-form.php');
 elseif(!is_connected() && $_GET['p']=='register') include('creationcompte-form.php');
 elseif(!is_connected() && $_GET['p']=='forgot') include('forgot.php');
 elseif(is_connected() && $_GET['p']=='profile') include('Mon-profil.php');
 else include('404.php');
 
	  ?>

<div class="spacer"></div>
</div>
</div>
<?php include "footer.php"; } ?>
</body>
</html>