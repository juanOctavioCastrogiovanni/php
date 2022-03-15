<?php
	include "./Class/Producto.class.php";
	include "./admin/conexion.php";

	$stmt = $conexion -> prepare("SELECT * FROM productos LIMIT 6");
	$stmt->execute();
	$i=0;
	$productosArray = array();

	while($productos = $stmt->fetch(PDO::FETCH_ASSOC)){
		array_push($productosArray,new Producto($productos['idProducto'],$productos['Nombre'],$productos['Precio'],$productos['Marca'],$productos['imagen']));
	}

	// echo "<pre>";
	// var_dump($productosArray);
	// echo "</pre>";
	// die();

	// $query = $conexion->query("SELECT P.idProducto, P.Nombre, P.Precio, P.Imagen, M.Nombre AS Marca FROM productos AS P INNER JOIN marcas AS M ON M.idMarca = P.Marca WHERE P.Destacado = 1 LIMIT 0, 6");
	
	// $productosDestacados = array();

	// foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $registro) {
		
	// 	$producto = new Producto($registro["idProducto"], $registro["Nombre"], $registro["Precio"], $registro["Marca"], $registro["Imagen"]);

	// 	print_r( $producto );

	// 	array_push($productosDestacados, $producto);
	// }

?>

<!-- PRODUCTOS DESTACADOS -->
	<div class="shoes-grid">
		<div class="products">
			<h5 class="latest-product">PRODUCTOS DESTACADOS</h5>
		</div>
		<div class="product-left">
			<!-- Producto #1 -->
			<div class="col-sm-4 col-md-4 chain-grid">
				<a href="?page=producto"><img class="img-responsive chain" src="images/productos/P001.jpg" alt=" " /></a>
				<div class="grid-chain-bottom">
					<h6><a href="?page=producto">Lorem ipsum dolor #1</a></h6>
					<div class="star-price">
						<div class="dolor-grid"> 
							<span class="actual">300$</span>
						</div>
						<a class="now-get get-cart" href="?page=producto">VER MÁS</a> 
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- Producto #2 -->
			<div class="col-sm-4 col-md-4 chain-grid">
				<a href="?page=producto"><img class="img-responsive chain" src="images/productos/P002.jpg" alt=" " /></a>
				<div class="grid-chain-bottom">
					<h6><a href="?page=producto">Lorem ipsum dolor #2</a></h6>
					<div class="star-price">
						<div class="dolor-grid"> 
							<span class="actual">300$</span>
						</div>
						<a class="now-get get-cart" href="?page=producto">VER MÁS</a> 
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- Producto #3 -->
			<div class="col-sm-4 col-md-4 chain-grid grid-top-chain">
				<a href="?page=producto"><img class="img-responsive chain" src="images/productos/P003.jpg" alt=" " /></a>
				<div class="grid-chain-bottom">
					<h6><a href="?page=producto">Lorem ipsum dolor #3</a></h6>
					<div class="star-price">
						<div class="dolor-grid"> 
							<span class="actual">300$</span>
						</div>
						<a class="now-get get-cart" href="?page=producto">VER MÁS</a> 
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
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
			<div class="col-sm-4 col-md-4 chain-grid">
				<a href="?page=producto"><img class="img-responsive chain" src="images/productos/P004.jpg" alt=" " /></a>
				<span class="star"></span>
				<div class="grid-chain-bottom">
					<h6><a href="?page=producto">Lorem ipsum dolor #1</a></h6>
					<div class="star-price">
						<div class="dolor-grid"> 
							<span class="actual">300$</span>
						</div>
						<a class="now-get get-cart" href="?page=producto">VER MÁS</a> 
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- Producto #2 -->
			<div class="col-sm-4 col-md-4 chain-grid">
				<a href="?page=producto"><img class="img-responsive chain" src="images/productos/P005.jpg" alt=" " /></a>
				<span class="star"></span>
				<div class="grid-chain-bottom">
					<h6><a href="?page=producto">Lorem ipsum dolor #2</a></h6>
					<div class="star-price">
						<div class="dolor-grid"> 
							<span class="actual">300$</span>
						</div>
						<a class="now-get get-cart" href="?page=producto">VER MÁS</a> 
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- Producto #3 -->
			<div class="col-sm-4 col-md-4 chain-grid grid-top-chain">
				<a href="?page=producto"><img class="img-responsive chain" src="images/productos/P006.jpg" alt=" " /></a>
				<span class="star"></span>
				<div class="grid-chain-bottom">
					<h6><a href="?page=producto">Lorem ipsum dolor #3</a></h6>
					<div class="star-price">
						<div class="dolor-grid"> 
							<span class="actual">300$</span>
						</div>
						<a class="now-get get-cart" href="?page=producto">VER MÁS</a> 
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"> </div>
	</div>