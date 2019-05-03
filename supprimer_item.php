<?php
include 'fonction_sql.php';
$index  = isset($_POST["index"])?$_POST["index"] : ""; 
supp_item($index);
header("Location:pdv.php");
?>