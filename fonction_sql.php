<?php

session_start();

define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','amazonece');

class DB{
	private $instance = null;
	

	public function get_instance(){
		if(is_null($this->instance)){
			$this->generate_instance();
		}
		return $this->instance;
	}
	public function generate_instance(){
		$this->instance = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	}
}
global $database;
$database = new DB();
$database->get_instance();

function creer_adresse($A,$V,$CP,$PA,$PH){
	global $database;

	$sql = "INSERT INTO `adresse`(`adresse_l1`, `ville`, `code_postal`, `pays`, `telephone`) VALUES ('$A','$V','$CP','$PA','$PH')";
	mysqli_query($database->get_instance(), $sql);
}

function creer_db($type,$num_carte,$num_affiche,$date_exp,$code_secur){
	global $database;

	$sql = "INSERT INTO donnee_bancaire(type, numero_carte, num_affiche,date_exp, code_secur) VALUES ('$type','$num_carte','$num_affiche','$date_exp','$code_secur')"; 
	mysqli_query($database->get_instance(), $sql);
}

function ajout_user($N,$SN,$M,$STATUS,$PW,$SX,$B,$PS,$A,$V,$CP,$PA,$PH){

	global $database;

	$sql_test_nom = "SELECT COUNT(*) FROM utilisateur WHERE nom = '$N' and prenom = '$SN' ";
	$result = mysqli_query($database->get_instance(),$sql_test_nom);
	$data = mysqli_fetch_array($result);

	$sql_test_nom = "SELECT COUNT(*) FROM utilisateur WHERE email='$M' ";
	$resultat = mysqli_query($database->get_instance(),$sql_test_nom);
	$data2 = mysqli_fetch_array($resultat);

	if($data[0] > 0 or $data2[0] > 0) {
		echo "erreur même nom/prenom ou même mail";
	}

	else {
		$sql1 = "INSERT INTO `utilisateur`(`nom`, `prenom`, `email`, `statut`, `mdp`, `sexe`, `date_de_naissance`, `pseudo`, `connet`) VALUES ('$N','$SN','$M','$STATUS','$PW','$SX','$B','$PS','0')";
			mysqli_query($database->get_instance(), $sql1);

		//prise de l'id user
		$id_sql = "SELECT `id_user` FROM `utilisateur` WHERE `nom` = '$N' and `prenom` = '$SN' and `pseudo`='$PS'";
		$id = mysqli_query($database->get_instance(), $id_sql);
		$data = mysqli_fetch_array($id);
		$id_num = $data[0];

		if($STATUS == "acheteur"){
			//création du panier
			$sql2 = "INSERT INTO `panier`(`nom`, `prenom`, `prix_tot`) VALUES ('$N','$SN','0')";
			mysqli_query($database->get_instance(), $sql2);

			$id_sql = "SELECT id_panier FROM panier ORDER BY `id_panier` DESC LIMIT 1";
			$id = mysqli_query($database->get_instance(), $id_sql);
			$data = mysqli_fetch_array($id);
			$id_panier = $data[0];

			$sql_add_id_panier = "UPDATE `utilisateur` set `id_panier`='$id_panier' WHERE `id_user` = '$id_num'";
			mysqli_query($database->get_instance(), $sql_add_id_panier);
		}

		//ajout de l'adresse : 
		$sql_adress = "INSERT INTO `adresse`(`adresse_l1`, `ville`, `code_postal`, `pays`, `telephone`) VALUES ('$A','$V','$CP','$PA','$PH')";
		var_dump($sql_adress);
		mysqli_query($database->get_instance(),$sql_adress);

		//initialisation donnée bancaire :
		$sql_bd = "INSERT INTO `donnee_bancaire`(`type`) VALUES ('')";
		mysqli_query($database->get_instance(),$sql_bd);

		$id_sql = "SELECT * FROM adresse ORDER BY `id_ad` DESC LIMIT 1";
		$id = mysqli_query($database->get_instance(), $id_sql);
		$data = mysqli_fetch_array($id);
		$id_adress = $data[0];
		var_dump($id_adress);

		$id_sql = "SELECT * FROM donnee_bancaire ORDER BY `id_db` DESC LIMIT 1";
		$id = mysqli_query($database->get_instance(), $id_sql);
		$data = mysqli_fetch_array($id);
		$id_bdonnee = $data[0];

		$sql_add_ad = "UPDATE `utilisateur` set `id_db`='$id_bdonnee',`id_ad`='$id_adress' WHERE `id_user` = '$id_num'";
		var_dump($sql_add_ad);
		mysqli_query($database->get_instance(), $sql_add_ad);
	}
}

function delete_user($id_user){
	global $database;

	$test_admin = test_id_connecte_admin(id_connecte());

	if($test_admin){
		$sql = "SELECT statut FROM utilisateur WHERE id_user = '$id_user'";
		$statut = mysqli_fetch_assoc(mysqli_query($database->get_instance(),$sql));
		var_dump($statut);
		
		if($statut['statut'] === "acheteur"){

		}
		if($statut['statut'] === 'vendeur'){
			// tu prend le stock du vendeur
			$tab_item = get_stock($id_user);
			var_dump($tab_item);

			// pour chacun de ses items tu les supprime dans les panier des acheteurs et deduit du prix total du panier :
			for ($i=0; $i < sizeof($tab_item) ; $i++) { 
				$sql = "SELECT * FROM user_item_panier WHERE id_item =". $tab_item[$i][0];
				$prix_tot = mysqli_fetch_assoc(mysqli_query($database->get_instance(),$sql));
				var_dump($prix_tot);
				if(!is_null($prix_tot)){
					$id_user_panier = $prix_tot['id_user'];
					$sql = "UPDATE panier set prix_tot = prix_tot - ".$prix_tot['prix_total'];
					var_dump($sql);
					mysqli_query($database->get_instance(),$sql);
				}
				$sql = "DELETE FROM user_item_panier WHERE id_item = ". $tab_item[$i][0];
				var_dump($sql);
				mysqli_query($database->get_instance(),$sql);
			}
			$sql = "DELETE FROM item where id_vendeur = '$id_user'";
			var_dump($sql);
			mysqli_query($database->get_instance(),$sql);
		}

		$sql = "SELECT id_ad,id_db FROM utilisateur WHERE id_user = '$id_user'";
		$data = mysqli_fetch_assoc(mysqli_query($database->get_instance(),$sql));

		$sql = "DELETE FROM adresse WHERE id_ad = ". $data['id_ad'];
		mysqli_query($database->get_instance(),$sql);

		$sql = "DELETE FROM donnee_bancaire WHERE id_db = ". $data['id_db'];
		mysqli_query($database->get_instance(),$sql);

		$sql = "DELETE FROM utilisateur WHERE id_user = '$id_user'";
		mysqli_query($database->get_instance(),$sql);

	}
	else{
		echo "vous netes pas administrateur";
	}

	die();
}

function id_connecte(){

	global $database;

	//recherche de l'id connecté :
	$sql = "SELECT id_user FROM `utilisateur` WHERE connet = '1' ";
	$row = mysqli_query($database->get_instance(),$sql);
	$data = mysqli_fetch_array($row);
	$id_connect = $data[0];
	

	return $id_connect;
}

function connection($mdp,$email){
	
	global $database;


	$sql = "SELECT COUNT(*) FROM utilisateur WHERE mdp = '$mdp' and email = '$email'";
	$resultat = mysqli_query($database->get_instance(),$sql);
	$data = mysqli_fetch_array($resultat);

	if($data[0]>0) {

		$sql = "UPDATE utilisateur set connet = '0' ";
		mysqli_query($database->get_instance(),$sql);

		$sql = "UPDATE utilisateur set connet = '1' WHERE mdp = '$mdp' and email = '$email'";
		mysqli_query($database->get_instance(),$sql);

		$sql_nom = "SELECT nom from utilisateur WHERE mdp = '$mdp' and email = '$email'";
		$row = mysqli_query($database->get_instance(),$sql_nom);
		$data = mysqli_fetch_array($row);
		$nom = $data[0];
		echo "connecter en tant que " .$nom. ". Bienvenue!";
	}
	else {
		echo "erreure connection";
	}
}

function deconnection(){

	global $database;

	$sql = "UPDATE utilisateur set connet = '0' ";
	mysqli_query($database->get_instance(),$sql);	
}

function ajouter_item($nom,$descri,$categorie,$prix,$quantite,$photo){

	global $database;


	//recherche de l'id du vendeur :
	$id_vendeur = id_connecte();

	//ajout item dans la bdd item
	$sql_ajout_item = "INSERT INTO `item`(`id_vendeur`, `nom`, `description`, `categorie`, `prix_unite`, `quantite`,photo) VALUES ('$id_vendeur','$nom','$descri','$categorie','$prix','$quantite','$photo')";
	mysqli_query($database->get_instance(),$sql_ajout_item);		
}

function get_image($id_item){
	global $database;

	$sql = "SELECT photo FROM item WHERE id_item = '$id_item' ";
	$row = mysqli_fetch_assoc(mysqli_query($database->get_instance(),$sql));

	return $row['photo'];
}

function supp_item($id_item){

	global $database;

	$sql_supp = "DELETE FROM item where id_item = '$id_item'";
	mysqli_query($database->get_instance(), $sql_supp);

	$sql = "SELECT COUNT(*) FROM user_item_panier";
	$query = mysqli_query($database->get_instance(), $sql);
	$data = mysqli_fetch_all($query, MYSQLI_ASSOC);

	for ($i=0; $i < count($data) ; $i++) { 
		ajouter_item_panier($id_item,0);
	}	
}

function install_database(){
	global $database;
	$sql = "SHOW TABLES;";
	$query = mysqli_query($database->get_instance(), $sql);
	$data = mysqli_fetch_all($query, MYSQLI_ASSOC);

	if(count($data) > 0){
		echo 'database exist and has '.count($data).' databases in it';
	}else{
		echo 'database does not exist.';
	}
}

function find_item($id_item){
	global $database;
	$sql = "SELECT id_item, prix_unite, quantite from item WHERE id_item = $id_item";

	$row = mysqli_query($database->get_instance(),$sql);
	$data = mysqli_fetch_assoc($row);

	if(count($data) === 0){
		echo "Le produit n'existe pas";	
		return null;
	}

	return $data;
}

function ajouter_item_panier($id_item, $qty = 1){
	global $database;
	//connecter l'utilisateur dans BDD


		//recherche de l'id de l'acheteur :
		$id_user_acheteur = id_connecte();

		echo $id_user_acheteur;

		//vérification que l'item existe
		$item = find_item($id_item);
		if(is_null($item)) return;

		$sql = "SELECT u.nom, u.prenom, u.id_panier, p.prix_tot as panier_total FROM `utilisateur` u
		INNER JOIN panier p on p.id_panier = u.id_panier
		WHERE u.id_user = $id_user_acheteur";
		$row = mysqli_query($database->get_instance(),$sql);
		$panier = mysqli_fetch_assoc($row);

		$sql = "SELECT id_item, prix_total FROM `user_item_panier` WHERE id_user = $id_user_acheteur and id_item = $id_item and id_panier = ".$panier['id_panier'];
		$row = mysqli_query($database->get_instance(),$sql);
		$data = mysqli_fetch_assoc($row);

		if(is_null($data)){
			$add_item_to_cart_sql = "INSERT INTO user_item_panier (	id_user, id_item, id_panier, qty, prix_unitaire, prix_total ) 
			VALUES (".$id_user_acheteur.",".$id_item.", ".$panier['id_panier'].", ".$qty.", ".$item['prix_unite'].", ".$qty * $item['prix_unite']." ); 
			UPDATE panier SET prix_tot = prix_tot + ".($qty * $item['prix_unite']) ." WHERE id_panier = ".$panier['id_panier'];
		}elseif ($qty > 0){
			$add_item_to_cart_sql = "UPDATE user_item_panier SET qty = ".$qty.", prix_total = ".($qty * $item['prix_unite'])." WHERE id_user = $id_user_acheteur and id_item = $id_item and id_panier = ".$panier['id_panier']."; 
			UPDATE panier SET prix_tot = ".($panier['panier_total'] - $data['prix_total'] + ($qty * $item['prix_unite']))." WHERE id_panier = ".$panier['id_panier'];
		}else{
			$add_item_to_cart_sql = "DELETE FROM user_item_panier WHERE id_user = $id_user_acheteur and id_item = $id_item and id_panier = ".$panier['id_panier'] .";
			UPDATE panier SET prix_tot = ".($panier['panier_total'] - $data['prix_total'])." WHERE id_panier = ".$panier['id_panier'];
		}

		$row = mysqli_multi_query($database->get_instance(),$add_item_to_cart_sql);
}

function get_panier($id_user){
	global $database;


	$sql = "SELECT u.nom, u.prenom, u.id_panier, p.prix_tot as panier_total FROM `utilisateur` u
	INNER JOIN panier p on p.id_panier = u.id_panier
	WHERE u.id_user = $id_user";
	$row = mysqli_query($database->get_instance(),$sql);
	$panier = mysqli_fetch_assoc($row);

	$sql = "SELECT id_item, qty from user_item_panier where id_user = $id_user and id_panier = ".$panier['id_panier'];
	$row = mysqli_query($database->get_instance(),$sql);
	$data = mysqli_fetch_all($row);

	return($data);
}

function update_qty_vendu($tab_panier){
	global $database;

	for ($i=0; $i < sizeof($tab_panier); $i++) { 
		$sql ="UPDATE item set qty_vendu = qty_vendu + ".$tab_panier[$i][1]." WHERE id_item = ".$tab_panier[$i][0];
		mysqli_query($database->get_instance(),$sql);
	}
}

function achat_panier(){
	global $database;

	$id_user_acheteur = id_connecte();

	$sql = "SELECT u.nom, u.prenom, u.id_panier, p.prix_tot as panier_total FROM `utilisateur` u
	INNER JOIN panier p on p.id_panier = u.id_panier
	WHERE u.id_user = $id_user_acheteur";
	$row = mysqli_query($database->get_instance(),$sql);
	$panier = mysqli_fetch_assoc($row);

	$tab_panier = get_panier($id_user_acheteur);

	for ($i=0; $i < sizeof($tab_panier); $i++) { 
		$sql = "UPDATE item set quantite = quantite - ".$tab_panier[$i][1]." WHERE id_item= ".$tab_panier[$i][0];
		mysqli_query($database->get_instance(),$sql);
	}

	update_qty_vendu($tab_panier);


	$sql = "DELETE FROM user_item_panier WHERE id_user = $id_user_acheteur and id_panier = ".$panier['id_panier'];
	mysqli_query($database->get_instance(),$sql);

	$sql = "UPDATE panier set prix_tot = '0' WHERE id_panier = ".$panier['id_panier'];
	mysqli_query($database->get_instance(),$sql);	
}

function get_stock($id_user){
	global $database;

	$sql = "SELECT * FROM item WHERE id_vendeur = $id_user";
	$row = mysqli_fetch_all(mysqli_query($database->get_instance(),$sql));
	
	return $row;
}

function get_list_categorie($categorie){
	global $database;

	$sql = "SELECT * FROM item WHERE categorie = '$categorie'";
	$row = mysqli_query($database->get_instance(),$sql);
	$data = mysqli_fetch_all($row);

	var_dump($data);

	return ($data);
}

function define_var_item($id_item,$nom_var){

	global $database;

	//test si la variation se fait bien sur un vetement;
	$sql = "SELECT categorie FROM item WHERE id_item = '$id_item'";
	$row = mysqli_query($database->get_instance(),$sql);
	$data = mysqli_fetch_assoc($row);

	if($data['categorie'] === "vetement"){


		//test si cette variation n'existe pas déjà :
		$sql = "SELECT * FROM item_variation WHERE id_item='$id_item' and nom_var_item='$nom_var'";
		$row = mysqli_query($database->get_instance(),$sql);
		$data = mysqli_fetch_assoc($row);

		if(is_null($data)){
			$sql = "INSERT INTO item_variation (id_item,nom_var_item) VALUES ('$id_item','$nom_var')";
			mysqli_query($database->get_instance(),$sql);
		}else{
			echo "var existe deja";
		}
	}
}

function test_id_connecte_admin($id_user){

	global $database;

	$sql = "SELECT nom,prenom,email FROM utilisateur WHERE id_user = '$id_user'";
	$row = mysqli_query($database->get_instance(),$sql);
	$data = mysqli_fetch_assoc($row);

	if ($data['nom']==="Admin" && $data['prenom'] === "Admin" && $data['email'] === "Administrateur@gmail.fr"){
		return true;
	}
	return false;
}

function get_flash_vente(){
	global $database;

	$sql = "SELECT MAX(qty_vendu),id_item,categorie FROM item GROUP BY categorie";
	$row = mysqli_fetch_all(mysqli_query($database->get_instance(),$sql));
	
	return $row;
}

function get_list_vendeur(){
	global $database;

	$sql = "SELECT id_user FROM utilisateur WHERE connet = '1'";
	$row = mysqli_fetch_assoc(mysqli_query($database->get_instance(),$sql));
	var_dump($row);

	if (test_id_connecte_admin($row['id_user'])) {
		$sql = "SELECT nom,prenom,email FROM utilisateur WHERE statut = 'vendeur'";
		$row = mysqli_fetch_all(mysqli_query($database->get_instance(),$sql));

		var_dump($row);
	}
}

?>
