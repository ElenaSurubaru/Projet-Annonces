
<?php
require_once('conf.php');
require_once('helpers.php');
require_once('functions.php'); 
require_once('functions-users.php'); 

$token=htmlspecialchars($_GET['t']);
// filter_input(INPUT_GET)

 $db =connect();
$query = $db->prepare('SELECT reset_token FROM utilisateur WHERE reset_token = :reset_token');
$query->execute(['reset_token'=>$token]);

if($query->rowCount()==1)   {
    $query=$db->prepare('UPDATE utilisateur SET actif=1 ,reset_token=NULL WHERE reset_token = :reset_token');
    $query->execute(['reset_token'=>$token]);
    echo "votre compte est activé";
}
?>