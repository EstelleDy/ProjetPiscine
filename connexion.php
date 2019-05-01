<?php
$PS   = isset($_POST["pseudo"])?$_POST["pseudo"] : ""; 
$PW   = isset($_POST["password"])?$_POST["password"] : "";
$erreur = ""; 
 if($PS == "") {$erreur .= "Le champ Pseudo est vide. <br>";}  
 if($PW == "") {$erreur .= " Le champ Mot de Passe est vide. <br>";}   


  $logs= "root"; // il faudra faire la commande SQL pour aller chercher le login de l'utilisateur dans la BDD (SELECT pseudo FROM acheteur/vendeur/admin un truc comme ça de mémoire)
  $pass = "root";// il faudra faire la commande SQL pour aller chercher le login de l'utilisateur dans la BDD (SELECT password FROM acheteur/vendeur/admin)
  if($PS== $logs && $PW==$pass){
  header("Location:index_conn.html");
   	echo "Connexion réussie";
  }
  else{
  	echo "Le Pseudo ou le mot de passe ne correspond pas";
  }
?>