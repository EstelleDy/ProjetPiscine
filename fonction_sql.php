<?php

//ajouter un compte

	function creer_adresse()

	function ajout_user($N,$SN,$M,$STATUS,$PW,$SX,$B,$PS){

		define('DB_SERVER','localhost');
		define('DB_USER','root');
		define('DB_PASS','');
		//identifier le nom de la bdd
		$database="amazonece";
		//connecter l'utilisateur dans BDD
		$db_handle= mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
		$db_found=mysqli_select_db($db_handle,$database);

		$sql = "SELECT pseudo FROM utilisateur";
		$result = mysqli_query($db_handle, $sql);
		//Si le bdd existe faites le traitement
		if($db_found){
			$sql1 = "INSERT INTO `utilisateur`(`nom`, `prenom`, `email`, `statut`, `mdp`, `sexe`, `date_de_naissance`, `pseudo`, `connet`) VALUES ('$N','$SN','$M','$STATUS','$PW','$SX','$B','$PS','1')";
				mysqli_query($db_handle, $sql1);
			if($STATUS == "acheteur"){
				$id_sql = "SELECT `id_user` FROM `utilisateur` WHERE `nom` = '$N' and `prenom` = '$SN' and `pseudo`='$PS'";
				$id = mysqli_query($db_handle, $id_sql);
				$data = mysqli_fetch_array($id);
				$id_num = $data[0];
				$sql2 = "INSERT INTO `panier`(`nom`, `prenom`, `quantite`, `prix_tot`, `id_user`) VALUES ('$N','$SN','0','0','$id_num')";
				mysqli_query($db_handle, $sql2);
			}
			if($STATUS == "vendeur"){
				$id_sql = "SELECT `id_user` FROM `utilisateur` WHERE `nom` = '$N' and `prenom` = '$SN' and `pseudo`='$PS'";
				$id = mysqli_query($db_handle, $id_sql);
				$data = mysqli_fetch_array($id);
				$id_num = $data[0];
				$sql2 = "INSERT INTO `stock`(`nom`, `prenom`, `id_user`) VALUES ('$N','$SN','$id_num')";
				$resu = mysqli_query($db_handle, $sql2);
			}
			//if (mysqli_query($db_handle, $sql1)) {
				echo "The new user account " .$PS. " is now created.";
			//}

		}

	}

?>
