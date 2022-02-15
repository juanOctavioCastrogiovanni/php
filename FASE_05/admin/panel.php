<?php
	include("conexion.php");
	if (isset( $_GET["rta"]) ) {
		echo MostrarMensaje( $_GET["rta"] );
	}
	
	$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;

	require "./conexion.php";

	
	
?>
<h1>Listado de Productos</h1>

<a href="admin/?page=producto&amp;action=add" class="now-get">Nuevo producto</a>

<table>
	<tr>
		<th>Imagen</th>
		<th>Nombre</th>
		<th>Precio</th>
		<th>Marca</th>
		<th>Categoria</th>
		<th>Presentacion</th>
		<th>Stock</th>
		<th colspan="2">Acciones</th>
	</tr>
<?php

	//$productos = $conexion->prepare("SELECT * FROM Productos");
	
	ListarProductos($pagina,5); 
?>	
