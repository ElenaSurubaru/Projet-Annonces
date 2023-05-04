<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/styleidentifier.css" />
<?php
  require_once('conf.php');
  require_once('helpers.php');
  require_once('functions.php'); 
  require_once('functions-users.php'); 
if (isset($_POST['submit'])) {
    $token=htmlspecialchars($_POST['reset_token']);
    $db =connect();
    $query=$db->prepare( "SELECT * FROM utilisateur WHERE reset_token ='$token'");
    $query->execute(['reset_token'=>$token]);
    $result= $query->fetch();
    if(time()<$result['perime'])  {
    if($query->rowCount()==1)   {
        $pwd=htmlspecialchars($_POST['password']);
         $pwd2=htmlspecialchars($_POST['password2']);
          if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?+&]).{8,}$/',$pwd)) {   
            if($pwd===$pwd2) {
                $query=$db->prepare("UPDATE utilisateur SET reset_token = NULL, password_hash=:password_hash, perime=0 WHERE reset_token = :reset_token");

                $nouveau_mot_de_passe = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $query->execute(['reset_token'=>$token,'password_hash'=>$nouveau_mot_de_passe]);
                if($query->rowCount()) 
                echo "Le mot de passe de l'utilisateur a été réinitialisé avec succès.";
                else echo "probleme lors du changement de votre mot de passe";
            }
            else echo "les mots de passe ne corespond pas";
           
          } else {
            echo "Le mot de passe doit contenir 8 caractéres avec 1 minuscule, 1 majuscule et 1 caractere(&%+/$)";
        
             }
    } 
    else echo "lien invalide";
}     else echo "lien perimée";
}
$token=htmlspecialchars($_GET['t']);
$db =connect();
$query = $db->prepare('SELECT reset_token FROM utilisateur WHERE reset_token = :reset_token');
$query->execute(['reset_token'=>$token]);

if($query->rowCount()==1):?>
  <form action="identifier-form.php" method="post"> 
<input type="hidden" name="reset_token"  value="$token" >

<label for="password"><b>Password</b></label>
<input type="password" placeholder="Enter Password" name="password" required>

<label for="password"><b>Repeat password</b></label>
<input type="password" placeholder="Enter Password" name="password2" required>

<button type="submit">Modifier</button>
</form>
    <?php
    
else: 
    echo "Lien invalide, veuillez redemander un nouveau mot de passe";
endif;
?>
