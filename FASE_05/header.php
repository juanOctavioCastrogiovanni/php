<?php require_once("init.php"); ?>
<!DOCTYPE html>
<html>
	<head>
	<title>ComercioIT | Tu E-Shop en PHP</title>
	<base href="http://<?php echo $_SERVER["SERVER_NAME"] . DIR_RAIZ; ?>/">
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<!--theme-style-->
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />	
	<!--//theme-style-->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!--fonts-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
	<!--//fonts-->
	<script src="js/jquery.min.js"></script>
	<!--script-->
	</head>
	<body> 
		<!--header-->
		<div class="header">
			<div class="bottom-header">
				<div class="container">
					<div class="header-bottom-left">
						<div class="logo"><a href="./">Comercio<strong>IT</strong></a></div>
						<div class="search">
							<input type="text" name="q">
							<input type="submit" value="BUSCAR">
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="header-bottom-right">					
						<!--div class="account">
							<a href="ingreso.html"><span></span> TU CUENTA</a>
						</div-->
						<ul class="login">
							<?php
								session_start();

								if(isset($_SESSION)&&count($_SESSION)>0){
									echo "<li><a href='admin/?page=panel'>Bienvenido ".$_SESSION['Nombre']."</a></li>&nbsp;|&nbsp;";
									echo "<li><a href='admin/?page=usuario&exit=exit'>CERRAR SESION</a></li>";
								} else {
									echo "<li><a href='./admin/?page=ingreso'><span></span> INGRESAR</a></li>&nbsp;|&nbsp;";
									echo "<li><a href='./admin/?page=registro'>REGISTRARTE</a></li>";
								}
							?>
							&nbsp;|&nbsp;
							<li><a href="?page=contacto">CONTACTO</a></li>
						</ul>
						<!--div class="cart"><a href="#"><span></span>CART</a></div-->
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>	
				</div>
			</div>
		</div>
		<!---->
		<div class="container">