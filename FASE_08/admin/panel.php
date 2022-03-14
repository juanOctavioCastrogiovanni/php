<?php
	
	validarSesion();


	include("conexion.php");
	if (isset( $_GET["rta"]) ) {
		echo MostrarMensaje( $_GET["rta"] );
	}
	if ( isset($_GET["p"]) ) {
		$pagina = $_GET["p"];
	} else {
		$pagina = 1;
	}
?>
<h1>Listado de Productos</h1>
<a href="admin/?page=producto&amp;action=add" class="now-get">Nuevo producto</a>
<?php ListarProductos($pagina, 5); ?>