<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS','');
//identifier le nom de la bdd
$database="amazonece";
//connecter l'utilisateur dans BDD
$db_handle= mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
$db_found=mysqli_select_db($db_handle,$database);
$STATUS=isset($_POST["status"])?$_POST["status"]:"";
$SX=isset($_POST["sex"])?$_POST["sex"]:"";
$B=isset($_POST["birthday"])?$_POST["birthday"]:"";
$N=isset($_POST["name"])?$_POST["name"]:"";
$SN=isset($_POST["surname"])?$_POST["surname"]:"";
$PH=isset($_POST["phone"])?$_POST["phone"]:"";
$A=isset($_POST["adress"])?$_POST["adress"]:"";
$CP=isset($_POST["CP"])?$_POST["CP"]:"";
$V=isset($_POST["ville"])?$_POST["ville"]:"";
$PA=isset($_POST["pays"])?$_POST["pays"]:"";
$PS=isset($_POST["pseudo"])?$_POST["pseudo"]:"";
$M=isset($_POST["mail"])?$_POST["mail"]:"";
$PW=isset($_POST["password"])?$_POST["password"]:"";
$error="";
if($STATUS==""){
	$error .= "Le champ Statut est vide <br/>";
}
if($SX==""){
	$error .= "Le champ Sexe est vide <br/>";
}
 if($B==""){
	$error .= "Le champ Date de Naissance est vide <br/>";
}
if($N==""){
	$error .= "Le champ Nom est vide <br/>";
}
if($SN==""){
	$error .= "Le champ Prénom est vide <br/>";
}
if($PH==""){
	$error .= "Le champ Téléphone est vide <br/>";
}
if($A==""){
	$error .= "Le champ Adresse est vide <br/>";
}
 if($CP==""){
	$error .= "Le champ Code Postal est vide <br/>";
}
if($V==""){
	$error .= "Le champ Ville est vide <br/>";
}
if($PA==""){
	$error .= "Le champ Pays est vide <br/>";
}
if($PS==""){
	$error .= "Le champ Pseudo est vide <br/>";
}
if($M==""){
	$error .= "Le champ Mail est vide <br/>";
}
 if($PW==""){
	$error .= "Le champ Password est vide <br/>";
}



if($error==""){
	header("Location:connexion.html");
}
else{
	echo " Erreur: $error";
}


//Si le bdd existe faites le traitement
if($db_found){

}
?>
