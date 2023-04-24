<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/styleidentifier.css"/>
<h1>Veuillez renseigner votre adresse email pour la réinitialisation de mot de passe</h1>
<?php
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
         if($query->rowCount())   {
            $token=bin2hex(random_bytes(16));
            $perim=time()+1200;
            $url="reset-password.php?t=$token";
    $subject="reinitialisation de mot de passe";
    $message="<a href='$url'>Cliquez ici</a>";
     $headers = 'MIME-Version: 1.0 \r\n'. 'Content-type: text/html; charset=iso-8859-1';
   
    if (mail($safe_email, $subject, $message, $headers)) {
        echo "Un mail vient de vous etre envoyée.";
        $query=$db->prepare("UPDATE utilisateur SET reset_token = :reset_token, perime=:perime WHERE email = :email");
        $query->execute(['email'=>$safe_email,'reset_token'=>$token,'perime'=>$perim]);

    } else {
        echo "Probleme avec l'envoie de mail";
    }
}
      }

    }
    
    
?>

<form action="" method="post">

    <label for="name"><b>Email</b></label>
    <input type="email" placeholder="Enter Email" name="email" required>

    
    <button type="submit">Envoyér</button>

</form>