<?php
	include "./Class/Producto.class.php";
	include "./Class/Tarjeta.class.php";
	include "./admin/conexion.php";

	// $stmt = $conexion -> prepare("SELECT * FROM productos LIMIT 6");
	// $stmt->execute();
	// $i=0;
	// $productosArray = array();

	// while($productos = $stmt->fetch(PDO::FETCH_ASSOC)){
	// 	array_push($productosArray,new Producto($productos['idProducto'],$productos['Nombre'],$productos['Precio'],$productos['Marca'],$productos['imagen']));
	// }

	// // echo "<pre>";
	// // var_dump($productosArray);
	// // echo "</pre>";
	// // die();

	$query = $conexion->query("SELECT P.idProducto, P.Nombre, P.Precio, P.Imagen, M.Nombre AS Marca FROM productos AS P INNER JOIN marcas AS M ON M.idMarca = P.Marca WHERE P.Destacado = 1 LIMIT 0, 6");
	
	$productosDestacados = array();

	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $registro) {
		
		$producto = new Producto($registro["idProducto"], $registro["Nombre"], $registro["Precio"], $registro["Marca"], $registro["Imagen"]);

		//Para imprimir objetos
		// print_r( $producto );

		array_push($productosDestacados, $producto);
	}

	$query2 = $conexion->query("SELECT P.idProducto, P.Nombre, P.Precio, P.Imagen, M.Nombre AS Marca FROM productos AS P INNER JOIN marcas AS M ON M.idMarca = P.Marca WHERE P.Destacado = 0 LIMIT 0, 6");
	
	$productosNormales = array();

	foreach ($query2->fetchAll(PDO::FETCH_ASSOC) as $registro) {
		array_push($productosNormales, new Producto($registro["idProducto"], $registro["Nombre"], $registro["Precio"], $registro["Marca"], $registro["Imagen"]));
	}

?>

<!-- PRODUCTOS DESTACADOS -->
	<div class="shoes-grid">
		<div class="products">
			<h5 class="latest-product">PRODUCTOS DESTACADOS</h5>
		</div>
		<div class="product-left">
		<?php
			new Tarjeta($productosDestacados,0);
		?>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"> </div>
	</div>
	<!-- ULTIMOS PRODUCTOS -->
	<div class="shoes-grid">
		<div class="products">
			<h5 class="latest-product">ULTIMOS PRODUCTOS</h5>	
			<a class="view-all" href="?page=productos">VER TODOS<span></span></a>
		</div>
		<div class="product-left">
			<!-- Producto #1 -->
			<?php
			new Tarjeta($productosNormales,1);
		?>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"> </div>
	</div>