<?php
//ajouter un compte
	function creer_adresse($A,$V,$CP,$PA,$PH){
		define('DB_SERVER','localhost');
		define('DB_USER','root');
		define('DB_PASS','');
		//identifier le nom de la bdd
		$database="amazonece";
		//connecter l'utilisateur dans BDD
		$db_handle= mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
		$db_found=mysqli_select_db($db_handle,$database);
		if($db_found){
			$sql1 = "INSERT INTO `adresse`(`adresse_l1`, `ville`, `code_postal`, `pays`, `telephone`) VALUES ('$A','$V','$CP','$PA','$PH')";
			mysqli_query($db_handle,$sql1);
		}
	}
	function ajout_user($N,$SN,$M,$STATUS,$PW,$SX,$B,$PS,$A,$V,$CP,$PA,$PH){
		define('DB_SERVER','localhost');
		define('DB_USER','root');
		define('DB_PASS','');
		//identifier le nom de la bdd
		$database="amazonece";
		//connecter l'utilisateur dans BDD
		$db_handle= mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
		$db_found=mysqli_select_db($db_handle,$database);
		//Si le bdd existe faites le traitement
		if($db_found){
			$sql_test_nom = "SELECT COUNT(*) FROM utilisateur WHERE nom = '$N' and prenom = '$SN' ";
			$result = mysqli_query($db_handle,$sql_test_nom);
			$data = mysqli_fetch_array($result);
			$sql_test_nom = "SELECT COUNT(*) FROM utilisateur WHERE email='$M' ";
			$resultat = mysqli_query($db_handle,$sql_test_nom);
			$data2 = mysqli_fetch_array($resultat);
			if($data[0] > 0 or $data2[0] > 0) {
				echo "erreur";
			}
			else {
				$sql1 = "INSERT INTO `utilisateur`(`nom`, `prenom`, `email`, `statut`, `mdp`, `sexe`, `date_de_naissance`, `pseudo`, `connet`) VALUES ('$N','$SN','$M','$STATUS','$PW','$SX','$B','$PS','0')";
					mysqli_query($db_handle, $sql1);
					//prise de l'id user
					$id_sql = "SELECT `id_user` FROM `utilisateur` WHERE `nom` = '$N' and `prenom` = '$SN' and `pseudo`='$PS'";
					$id = mysqli_query($db_handle, $id_sql);
					$data = mysqli_fetch_array($id);
					$id_num = $data[0];
				if($STATUS == "acheteur"){
					//création du panier
					$sql2 = "INSERT INTO `panier`(`nom`, `prenom`, `quantite`, `prix_tot`, `id_user`) VALUES ('$N','$SN','0','0','$id_num')";
					mysqli_query($db_handle, $sql2);
					//ajout à la base acheteur
					$id_sql = "SELECT * FROM panier ORDER BY `id_panier` DESC LIMIT 1";
					$id = mysqli_query($db_handle, $id_sql);
					$data = mysqli_fetch_array($id);
					$id_panier = $data[0];
					$sql2 = "INSERT INTO `acheteur`(`id_panier`, `id_user`) VALUES ('$id_panier','$id_num')";
					mysqli_query($db_handle, $sql2);
				}
				if($STATUS == "vendeur"){
					//création stock
					$sql2 = "INSERT INTO `stock`(`nom`, `prenom`, `id_user`) VALUES ('$N','$SN','$id_num')";
					$resu = mysqli_query($db_handle, $sql2);
					//ajout à la base vendeur
					$id_sql = "SELECT * FROM stock ORDER BY `id_stock` DESC LIMIT 1";
					$id = mysqli_query($db_handle, $id_sql);
					$data = mysqli_fetch_array($id);
					$id_stock = $data[0];
					$sql2 = "INSERT INTO `vendeur`(`id_stock`, `id_user`) VALUES ('$id_stock','$id_num')";
					mysqli_query($db_handle, $sql2);
				}
				//ajout de l'adresse : 
				$sql_adress = "INSERT INTO `adresse`(`adresse_l1`, `ville`, `code_postal`, `pays`, `telephone`) VALUES ('$A','$V','$CP','$PA','$PH')";
				mysqli_query($db_handle,$sql_adress);
				//initialisation donnée bancaire :
				$sql_bd = "INSERT INTO `donnee_bancaire`(`type`) VALUES ('')";
				mysqli_query($db_handle,$sql_bd);
				$id_sql = "SELECT * FROM adresse ORDER BY `id_ad` DESC LIMIT 1";
				$id = mysqli_query($db_handle, $id_sql);
				$data = mysqli_fetch_array($id);
				$id_adress = $data[0];
				$id_sql = "SELECT * FROM donnee_bancaire ORDER BY `id_db` DESC LIMIT 1";
				$id = mysqli_query($db_handle, $id_sql);
				$data = mysqli_fetch_array($id);
				$id_bdonnee = $data[0];
				$sql_add_ad = "UPDATE `utilisateur` set `id_db`='$id_bdonnee',`id_ad`='$id_adress' WHERE `id_user` = '$id_num'";
				mysqli_query($db_handle, $sql_add_ad);
			}
		}
		mysqli_close($db_handle);
	}
	function connection($mdp,$email){
		
		define('DB_SERVER','localhost');
		define('DB_USER','root');
		define('DB_PASS','');
		//identifier le nom de la bdd
		$database="amazonece";
		//connecter l'utilisateur dans BDD
		$db_handle= mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
		$db_found=mysqli_select_db($db_handle,$database);
		if($db_found){
			$sql = "SELECT COUNT(*) FROM utilisateur WHERE mdp = '$mdp' and email = '$email'";
			$resultat = mysqli_query($db_handle,$sql);
			$data = mysqli_fetch_array($resultat);
			if($data[0]>0) {
				$sql = "UPDATE utilisateur set connet = '0' ";
				mysqli_query($db_handle,$sql);
				$sql = "UPDATE utilisateur set connet = '1' WHERE mdp = '$mdp' and email = '$email'";
				mysqli_query($db_handle,$sql);
				$sql_nom = "SELECT nom from utilisateur WHERE mdp = '$mdp' and email = '$email'";
				$row = mysqli_query($db_handle,$sql_nom);
				$data = mysqli_fetch_array($row);
				$nom = $data[0];
				echo "connecter en tant que " .$nom. ". Bienvenue!";
			}
			else {
				echo "erreure connection";
			}
		}
	}
	function ajouter_item($nom,$descri,$categorie,$prix,$quantite){
		define('DB_SERVER','localhost');
		define('DB_USER','root');
		define('DB_PASS','');
		//identifier le nom de la bdd
		$database="amazonece";
		//connecter l'utilisateur dans BDD
		$db_handle= mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
		$db_found=mysqli_select_db($db_handle,$database);
		if($db_found){
			//recherche de l'id du vendeur :
			$sql = "SELECT * FROM `utilisateur` WHERE connet = '1' ";
			$row = mysqli_query($db_handle,$sql);
			$data = mysqli_fetch_array($row);
			$id_vendeur = $data[0];
			$sql = "SELECT * FROM vendeur WHERE id_user = '$id_vendeur'";
			$row = mysqli_query($db_handle,$sql);
			$data = mysqli_fetch_array($row);
			$id_stock = $data[1];
			//ajout item dans la bdd item
			$sql_ajout_item = "INSERT INTO `item`(`id_vendeur`, `nom`, `description`, `categorie`, `prix_unite`, `quantite`, `id_stock`) VALUES ('$id_vendeur','$nom','$descri','$categorie','$prix','$quantite','$id_stock')";
			mysqli_query($db_handle,$sql_ajout_item);
			
		}
	}
	function supp_item($id_item){
		define('DB_SERVER','localhost');
		define('DB_USER','root');
		define('DB_PASS','');
		//identifier le nom de la bdd
		$database="amazonece";
		//connecter l'utilisateur dans BDD
		$db_handle= mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
		$db_found=mysqli_select_db($db_handle,$database);
		if($db_found){
			$sql_supp = "DELETE FROM item where id_item = '$id_item'";
			mysqli_query($db_handle,$sql_supp);
		}
	}
?>