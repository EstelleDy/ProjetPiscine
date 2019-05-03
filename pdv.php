<!DOCTYPE HTML>

<!--
	Escape Velocity by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Votre page de vente</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="left-sidebar is-preload">
		<div id="page-wrapper">

			<!-- Header -->
				<section id="header" class="wrapper">

					<!-- Logo -->
						<div id="logo">
							<h1><a href="index_conn_vendeur.html">Amazon ECE</a></h1>
							<p>E-commerce de l'ECE</p>
							<br/>
							<form action="deconnexion.php" method="post"> 
							<input type="submit" value="Se déconnecter" >
						</form>
						</div>

					<!-- Nav -->
						<nav id="nav">
							<ul>
								<li class="current"><a href="index_conn_vendeur.html">Home</a></li>
								<li><a href="pdv.php">Ma page de vente</a></li>
								<li><a href="ajouter_item.html">Ajouter des articles à vendre</a></li>
							</ul>
						</nav>

				</section>

			<!-- Main -->
				<section id="main" class="wrapper style2">
					<div class="title">Votre Page de vente</div>
					<div class="container">
								<!-- Content -->
								<br/><h1> <font size= 8> <strong>Vos articles à vendre: </strong> </font></h1><br/>
								<br/><br/><br/> <br/>
									<div class="row gtr-150">
										<div class="grid-container col-4 col-12-small">
									<?php 
									include 'fonction_sql.php';
									$id_user= id_connecte();
									

									$row=get_stock($id_user);
									$taille=sizeof($row);
									for($i=0;$i<$taille;$i++){

										?> <div class="grid"> <?php
										
										$index=$row[$i][0];
										echo "Item :";
										
										
										echo  json_encode($row[$i][2]) . '<br/>'; 
										echo "  Description : " ;
										echo json_encode( $row[$i][3]) .'<br/>';
									    echo "  Prix : ";
									    echo  json_encode($row[$i][5]) . " euros<br/>";
										echo  "  Quantité restante: " ;
										echo json_encode( $row[$i][6]) .'<br/>';
										?><br/>
							<form action ="supprimer_item.php" method="post">			
								<div>
							<input type="hidden" name="index" value="<?php echo $index; ?>" />
							<input type="submit" value="Supprimer item" ></div></form> </div> <?php

										}

									
									?>
									
						
									
									
								</div>			
						</div>
					</div>

										
										
				</section>

			<!-- Highlights -->
				<section id="highlights" class="wrapper style3">
					<div class="title">Catégories</div>
					<div class="container">
						<div class="row aln-center">
							<div class="col-3 col-12-medium">
								<section class="highlight">
									<a href="#" class="image featured"><img src="images/book.jpg" alt="" /></a>
									<h3><a href="#">Livres</a></h3>
									<ul class="actions">
										<li><a href="#" class="button style1">Achetez </a></li>
									</ul>
								</section>
							</div>
							<div class="col-3 col-12-medium">
								<section class="highlight">
									<a href="#" class="image featured"><img src="images/music.jpg" alt="" /></a>
									<h3><a href="#">Musique </a></h3>
									<ul class="actions">
										<li><a href="#" class="button style1">Achetez </a></li>
									</ul>
								</section>
							</div>
							<div class="col-3 col-12-medium">
								<section class="highlight">
									<a href="#" class="image featured"><img src="images/sport.jpg" alt="" /></a>
									<h3><a href="#">Sport et Loisirs</a></h3>
									<ul class="actions">
										<li><a href="#" class="button style1">Achetez </a></li>
									</ul>
								</section>
							</div>
							<div class="col-3 col-12-medium">
								<section class="highlight">
									<a href="#" class="image featured"><img src="images/clothes.jpg" alt="" /></a>
									<h3><a href="#">Vêtements </a></h3>
									<ul class="actions">
										<li><a href="#" class="button style1">Achetez </a></li>
									</ul>
								</section>
							</div>
						</div>
					</div>
				</section>
			<!-- Footer -->
				<section id="footer" class="wrapper">
					<div class="title">Un dernier petit mot  </div>
					<div class="container">
						<header class="style1">
							<h2>Envie de nous contacter ?</h2>
						</header>
						<div class="row">
							<div class="col-6 col-12-medium">
								<!-- Contact Form -->
									<section>
										<form method="post" action="#">
											<div class="row gtr-50">
												<div class="col-6 col-12-small">
													<input type="text" name="name" id="contact-name" placeholder="Nom" />
												</div>
												<div class="col-6 col-12-small">
													<input type="text" name="email" id="contact-email" placeholder="Email" />
												</div>
												<div class="col-12">
													<textarea name="message" id="contact-message" placeholder="Message" rows="4"></textarea>
												</div>
												<div class="col-12">
													<ul class="actions">
														<li><input type="submit" class="style1" value="Envoyer" /></li>
														<li><input type="reset" class="style2" value="Réinitialiser" /></li>
													</ul>
												</div>
											</div>
										</form>
									</section>
							</div>
							<div class="col-6 col-12-medium">

								<!-- Contact -->
									<section class="feature-list small">
										<div class="row">
											<div class="col-6 col-12-small">
												<section>
													<h3 class="icon fa-home">Voie Postale</h3>
													<p>
														Amazon ECE<br />
														37 Quai de Grenelle<br />
														75015,Paris
													</p>
												</section>
											</div>
											<div class="col-6 col-12-small">
												<section>
													<h3 class="icon fa-comment">Réseaux Sociaux</h3>
													<p>
														<a href="#">@AmazonEce</a><br />
														<a href="#">linkedin.com/AmazonEce</a><br />
														<a href="#">facebook.com/AmazonECE</a>
													</p>
												</section>
											</div>
											<div class="col-6 col-12-small">
												<section>
													<h3 class="icon fa-envelope">Email</h3>
													<p>
														<a href="#">info@amazonece.fr</a>
													</p>
												</section>
											</div>
											<div class="col-6 col-12-small">
												<section>
													<h3 class="icon fa-phone">Téléphone</h3>
													<p>	01 44 39 06 00 </p>
												</section>
											</div>
										</div>
									</section>
							</div>
						</div>
						<div id="copyright">
							<ul>
								<li>&copy; AmazonECE </li><li>Design: <a href="http://html5up.net">LA FAMILLE</a></li>
							</ul>
						</div>
					</div>
				</section>

		</div>
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>