<?php
	include("conexion.php");
	if (isset( $_GET["rta"]) ) {
		echo MostrarMensaje( $_GET["rta"] );
	}
?>
<h1>Listado de Productos</h1>
<a href="admin/?page=producto&amp;action=add" class="now-get">Nuevo producto</a>
<table>
	<tr>
		<th>Nombre</th>
		<th>Precio</th>
		<th>Marca</th>
		<th>Categoria</th>
		<th>Presentacion</th>
		<th>Stock</th>
		<th>Imagen</th>
		<th colspan="2">Acciones</th>
	</tr>
<?php

	//$productos = $conexion->prepare("SELECT * FROM Productos");
	$productos = $conexion->prepare("SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Stock, P.imagen, M.Nombre AS Marca, C.Nombre AS Categoria FROM productos AS P INNER JOIN marcas AS M ON P.Marca = M.idMarca INNER JOIN categorias AS C ON P.Categoria = C.idCategoria");
	$productos->execute();
	ListarProductos($productos);
?>	
</table>