<?php

function generate_sql_limit($limit=LIMIT,$page=1){
    if(!is_numeric($limit)) $limit = LIMIT;
    $t = ' LIMIT '.$limit;
    if(is_numeric($page) && $page > 1){
      $offset = $limit*($page-1);
      $t.= ' OFFSET '.$offset;
    }
    return $t;
  }
/**************************************
 * $name : name de l'input généré
 * $type : type de l'input, text par défaut
 * $value : valeur préremplie, vide par défaut
 * $id : id de l'input généré, si non fourni sera égale au name
 * Affiche un input prérempli
***************************************/
function affiche_input($name, $type="text",$value="",$id=null){
	$input="<input type='$type' value='$value' id='".($id ?? $name)."' name='$name'/>";
	echo $input;
}
// exemple d'utilisation
// affiche_input("nom",value:"Toto");

/**************************************
 * $cats : tableaux des résultats d'une requête de sélection de catégories
 * $name : name du select généré
 * $current : catégorie actuelle d'une annonce ou catégorie parente actuelle d'une catégorie, aucune par défaut
 * Affiche la liste déroulante des catégories avec la catégorie actuelle pré-selectionnée
***************************************/
function affiche_select_cat($cats, $name, $current=0){
	$select="<select name=$name>";
	$select.="<option value=0>Aucune</option>";
	foreach ($cats as $cat){ 
		//nom des champs à modifier en fonction de la structure de la table categories
		$s=(!empty($cat['id_categorie']) && $cat['id_categorie'] == $current) ? 'selected' : '';
        $select.="<option $s value='".$cat['id_categorie']."'>".$cat['nom_categorie']."</option>";
    }
	$select.="</select>";
	echo $select;
}


function affiche_select_etat($etats, $nom, $current=0){
	$select="<select name=$nom>";
	//$select.="<option value=0>Aucune</option>";
	foreach ($etats as $etat){ 
		//nom des champs à modifier en fonction de la structure de la table categories
		$s=(!empty($etat['id_etat']) && $etat['id_etat'] == $current) ? 'selected' : '';
        $select.="<option $s value=".$etat['id_etat'].">".$etat['libelle_etat']."</option>";
    }
	$select.="</select>";
	echo $select;
}

function affiche_select_paye($payements, $mode, $current=0){
	$select="<select name=$mode>";
	// $select.="<option value=0>Aucun</option>";
	foreach ($payements as $paye){ 
		//nom des champs à modifier en fonction de la structure de la table categories
		$s=(!empty($paye['id_mode_paiement']) && $paye['id_mode_paiement'] == $current) ? 'selected' : '';
        $select.="<option $s value=".$paye['id_mode_paiement'].">".$paye['libelle_mode_paiement']."</option>";
    }
	$select.="</select>";
	echo $select;
}
  
function affiche_select_user($users, $name, $current=0){
	$select="<select name=$name>";
	$select.="<option value=0>Aucun</option>";
	foreach ($users as $user){ 
		//nom des champs à modifier en fonction de la structure de la table categories
		$s=(!empty($user['id_utilisateur']) && $user['id_utilisateur'] == $current) ? 'selected' : '';
        $select.="<option $s value='".$user['id_utilisateur']."'>".$user['login']."</option>";
    }
	$select.="</select>";
	echo $select;
}




// exemple d'utilisation
// affiche_select_cat([['cat_id'=>1,'nom_cat'=>"Animaux"],['cat_id'=>2,'nom_cat'=>"Immobilier"]], "cat");

function is_date_fr($value) {
	if(Datetime::createFromFormat("d/m/Y",$value)) return true;
	return false;
  
  }
  function is_date_en($value) {
	if(Datetime::createFromFormat("Y-m-d",$value)) return true;
	return false;
  
  }
  //Vérifie que c'est une adresse email valide
  function is_email($email) {
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) return TRUE;
	 return FALSE;
	 
  }
  //Vérifie que c'est un numéro de téléphone de type entier composé de 10 chiffres
  
  function is_phone_number($number) {
	 if(preg_match('/^0[0-9]{9}$/',$number)) return true;
	 return false;
  
  }
  //Vérifie que c'est un code postal de 5 chiffres
  function is_zip_code($code) {
	if(preg_match('/^[0-9]{5}$/',$code)) return true;
	return false; 
  
  }
  
  //Vérifie que l'utilisateur a rentréé 2 fois le mot de passe
  function password_check($pwd,$pwd_b) {
	  if($pwd==$pwd_b) return TRUE;
	  return false;
  
  }
  //Vérifie transformation date format jj//mm/aaaa en date universelle au format aaaa-mm-jj
  function date_fr_to_en($date='') {
	if (is_date_fr($date)) {
	  // $date=date('Y-m-d',strtotime($date));
		$date = preg_replace('/^(\d{2})\/(\d{2})\/(\d{4})$/', '$3-$2-$1', $date);
	   return $date;
			 }
			 return FALSE;
	   }
	
  
	//   if(preg_match((^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$)),$date) return TRUE;
	//  return FALSE;
  
  
  //Vérifie transformation date universelle au format aaaa-mm-jj en date format jj//mm/aaaa
  function date_en_to_fr($date='') {
	  if (is_date_en($date)) {
	//  $date=date('d/m/Y',strtotime($date));
	 $date = preg_replace('/^(\d{4})-(\d{2})-(\d{2})$/', '$3/$2/$1', $date);
	 return $date;
		   }
		return FALSE;
	 }
?>
