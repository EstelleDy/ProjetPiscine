<?php
include 'fonction_sql.php';
$nom   = isset($_POST["nom_item"])?$_POST["nom_item"] : ""; 
$descri = isset($_POST["desc"])?$_POST["desc"] : "";
$categorie = isset($_POST["categ"])?$_POST["categ"] : "";
$prix = isset($_POST["price"])?$_POST["price"] : "";
$quantite = isset($_POST["qte"])?$_POST["qte"] : "";
$erreur = ""; 
ajouter_item($nom,$descri,$categorie,$prix,$quantite);
header("Location:item_added.html");
?>