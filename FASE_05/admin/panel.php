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
		<th colspan="2">Acciones</th>
	</tr>
<?php

	//$productos = $conexion->prepare("SELECT * FROM Productos");
	$productos = $conexion->prepare("SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Stock, M.Nombre AS Marca, C.Nombre AS Categoria FROM productos AS P INNER JOIN marcas AS M ON P.Marca = M.idMarca INNER JOIN categorias AS C ON P.Categoria = C.idCategoria");
	$productos->execute();
	while ( $producto = $productos->fetch() ) {
	?>
	<tr>
		<td><?php echo $producto["Nombre"]; ?></td>
		<td>$<?php echo $producto["Precio"]; ?></td>
		<td><?php echo $producto["Marca"]; ?></td>
		<td><?php echo $producto["Categoria"]; ?></td>
		<td><?php echo $producto["Presentacion"]; ?></td>
		<td><?php echo $producto["Stock"]; ?></td>
		<td>
			<a href="admin/?page=producto&amp;action=update&amp;id=<?php echo $producto["idProducto"]; ?>">Modificar</a>
		</td>
		<td>
			<a href="admin/?page=producto&amp;action=delete&amp;id=<?php echo $producto["idProducto"]; ?>">Eliminar</a>
		</td>
	</tr>
	<?php
	}
?>	
</table>