<?php 
require_once('conf.php');
require_once('helpers.php');
require_once('functions.php'); 
require_once('functions-users.php'); 
?>

<div id="top"> 
<ul>
    <li><a href="<?=URL_SITE;?>">Accueil</a></li>
	<li><a href="javascript:history.go(-1)">Retour</a></li>
	<li><a href="annonce-form.php">Créer une annonce</a></li>
	<li><a href="annonces.php">Consulter les annonces</a></li>

</ul>
<h1>Give-Buy-Sell</h1>
</div>
<div id="bar">
<!-- formulaire de recherche par mot clé -->
<form action="search.php" method="post">
Recherche par mots clés:
<input type="text" name="recherche" />
<br />
<!-- <input type="radio" name="mode" value="tous_les_mots">Tous les mots
<input type="radio" name="mode" value="un_mot" checked="checked">Au moins un mot -->
<input type="submit" value="Rechercher" name="recherches" />
</form>
</div>
