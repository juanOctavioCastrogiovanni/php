<?php
	include("conexion.php");
	
	function CargarPagina($pagina){
		$modulo = "./" . $pagina . ".php"; 
		if ( file_exists( $modulo ) ) {
			include( $modulo );
		} else {
			include( "404.php" );
		}
	}
	function MostrarMensaje($cod){

		switch ($cod) {
			case '0x001':
				$mensaje = "El nombre ingresado no es válido";
			break;
			
			case '0x002':
				$mensaje = "El e-mail ingresado no es válido";
			break;

			case '0x003':
				$mensaje = "El mensaje ingresado no es válido";
			break;

			case '0x004':
				$mensaje = "Su consulta ha sido enviada... muchas gracias!";
			break;

			case '0x005':
				$mensaje = "Ocurrio un error, intente de nuevo";
			break;

			case '0x006':
				$mensaje = "Se creo un nuevo producto satisfactoriamente";
			break;

			case '0x007':
				$mensaje = "Error al crear un producto";
			break;

			case '0x008':
				$mensaje = "Se actualizo el producto satisfactoriamente";
			break;

			case '0x009':
				$mensaje = "Error al actualizar el producto";
			break;

			case '0x010':
				$mensaje = "Se elimino el producto satisfactoriamente";
			break;

			case '0x011':
				$mensaje = "Error al eliminar el producto";
			break;	
			
			case '0x012':
				$mensaje = "Error al eliminar la foto anterior";
			break;	
		}
		return "<p class='rta rta-".$cod."'>".$mensaje."</p>";
	}
	function MostrarProductos(){
		if ( ($fichero = fopen("listadoProductos.csv", "r")) !== FALSE ) {
    		while ( ($datos = fgetcsv($fichero, 1000)) !== FALSE) {
    		?>
			<div class="product-grid">
				<div class="content_box">
					<a href="./?page=producto">
						<div class="left-grid-view grid-view-left">
							<img src="images/productos/<?php echo $datos[0]; ?>.jpg" class="img-responsive watch-right" alt=""/>
						</div>
					</a>
					<h4><a href="#"><?php echo $datos[4]; ?> - <?php echo $datos[1]; ?></a></h4>
					<p>Precio: $<?php echo $datos[2]; ?> - Presentacion: <?php echo $datos[5]; ?></p>
					<span>Stock: <?php echo $datos[3]; ?></span>
				</div>
			</div>
			<?php
    		}
    	}
    }

	function ListarProductos($pagina,$vista){
		global $conexion;

		// var_dump($ultima['total']);
		// die();

		$cantidad = $conexion->prepare("SELECT COUNT(*) FROM productos");

		$cantidad->execute();

		$cant = (int)($cantidad->fetch())[0];
				
		$productos = $conexion->prepare("SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Stock, P.imagen, M.Nombre AS Marca, C.Nombre AS Categoria FROM productos AS P INNER JOIN marcas AS M ON P.Marca = M.idMarca INNER JOIN categorias AS C ON P.Categoria = C.idCategoria LIMIT $vista OFFSET " . $pagina * $vista);
		
		$productos->execute();

		$productoss = $productos->fetchAll(PDO::FETCH_ASSOC);

		foreach ($productoss as $producto) {
		echo "<tr>";
			echo "<td>".$producto["Nombre"]."</td>";
			echo "<td>".$producto["Precio"]."</td>";
			echo "<td>".$producto["Marca"]."</td>";
			echo "<td>".$producto["Categoria"]."</td>";
			echo "<td>".$producto["Presentacion"]."</td>";
			echo "<td>".$producto["Stock"]."</td>";

			if($producto["imagen"]){
				echo "<td><img style='width:20%;' src='" . UPLOAD_PATH . $producto['imagen']. "'></td>";
			} else {
				echo "<td><p> Este producto no posee una imagen </p></td>";
			}

			echo "<td><a href='admin/?page=producto&amp;action=update&amp;id=". $producto['idProducto'] . "'>Modificar</a></td>";
			echo "<td><a href='admin/?page=producto&amp;action=delete&amp;id=". $producto['idProducto'] . "'>Eliminar</a></td>";

		echo "</tr>";
	}
		echo "</table>";

		$cantpag = pag($cant,$vista);

		if($cant != $vista){
		MostrarPaginador($pagina,$cantpag);
		}
	}

	function pag($productos,$vistas){
		$num = (int)($productos/$vistas);
		if($productos%$vistas != 0){
			$num++; 
		}

		return $num - 1;
	}

	function MostrarPaginador($paginaActual, $cantidadDePaginas){
		$despues = $paginaActual + 1;
		$antes = $paginaActual - 1; 

		if ($paginaActual > 0){
		echo "<a style='text-decoration:none;' href='admin/?page=panel&amp;pagina=". $antes."'>Anterior&nbsp&nbsp&nbsp&nbsp</a>";
		}		
		$j = 1;

		for ($i = 0; $i <= $cantidadDePaginas; $i++){
			if($i == $paginaActual){
				echo "<a style='text-decoration:none;' href='admin/?page=panel&amp;pagina=". $i."'><strong>$j</strong>&nbsp&nbsp</a>";
			} else {
				echo "<a style='text-decoration:none;' href='admin/?page=panel&amp;pagina=". $i."'>$j&nbsp&nbsp</a>";
			}

			$j++;
		}

		if($cantidadDePaginas > $paginaActual){
		echo "<a style='text-decoration:none;' href='admin/?page=panel&amp;pagina=". $despues."'>&nbsp&nbsp&nbspProxima</a>";
		}
	}

	//Funciones del Back-End
	function CrearProducto($nombre, $precio, $marca, $categoria, $presentacion, $stock, $imagen){
		global $conexion;
		$validacion = validacionImagen($imagen);
		$rta = "0x007";
		$producto = $conexion->prepare("INSERT INTO productos (Nombre, Precio, Marca, Categoria, Presentacion, Stock, imagen) VALUES (:nombre, :precio, :marca, :categoria, :presentacion, :stock, :imagen)");

		$producto->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$producto->bindParam(":precio", $precio, PDO::PARAM_STR);
		$producto->bindParam(":marca", $marca, PDO::PARAM_INT);
		$producto->bindParam(":categoria", $categoria, PDO::PARAM_INT);
		$producto->bindParam(":presentacion", $presentacion, PDO::PARAM_STR);
		$producto->bindParam(":stock", $stock, PDO::PARAM_INT);

		if($validacion){
			$producto->bindParam(":imagen", $validacion, PDO::PARAM_STR);
		} else {
			$producto->bindValue(':imagen', NULL, PDO::PARAM_NULL);
		}
		if ( $producto->execute() ) {
			$rta = "0x006";
		}
		header("location: " . BACK_END_URL . "/?rta=" . $rta);
	}

	function validacionImagen($imagen){
		if($imagen['imagenProducto']['name'] == 0){
			return NULL;
		}
		$temporal = $imagen['imagenProducto']['tmp_name'];
		$nombre = sha1_file($temporal);
		if(file_exists(UPLOAD_PATH_RELATIVE . $nombre)){
			return $nombre;
		}
		$esImagen = getimagesize($temporal);
		if($esImagen){
			if(move_uploaded_file($temporal, UPLOAD_PATH_RELATIVE. $nombre)){
				return $nombre;
			}
		}

		return FALSE;
	}
		
		function ActualizarProducto($id, $nombre, $precio, $marca, $categoria, $presentacion, $stock, $nombreAnterior ,$imagen){
		global $conexion;

		$validacion = validacionImagen($imagen);

		$rta = "0x009";
		$producto = $conexion->prepare("UPDATE productos SET Nombre = :nombre, Precio = :precio, Marca = :marca, Categoria = :categoria, Presentacion = :presentacion, Stock = :stock, imagen = :imagen WHERE idProducto = :id");
					
		$producto->bindParam(":id", $id, PDO::PARAM_INT);
		$producto->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$producto->bindParam(":precio", $precio, PDO::PARAM_STR);
		$producto->bindParam(":marca", $marca, PDO::PARAM_INT);
		$producto->bindParam(":categoria", $categoria, PDO::PARAM_INT);
		$producto->bindParam(":presentacion", $presentacion, PDO::PARAM_STR);
		$producto->bindParam(":stock", $stock, PDO::PARAM_INT);
		if($validacion){
			$producto->bindParam(":imagen", $validacion, PDO::PARAM_STR);
		} else {
			$producto->bindValue(':imagen', NULL, PDO::PARAM_NULL);
		}
		if ( $producto->execute() ) {
			$rta = "0x008";
		}
		
		if(!borrarImagen($nombreAnterior)){
			$rta = "0x012";
		}

	
		header("location: " . BACK_END_URL . "/?rta=" . $rta);
	}


	function BorrarProducto($id,$imagen){
		global $conexion;
		$rta = "0x011";
		$id = $_POST["id"];
		$producto = $conexion->prepare("DELETE FROM productos WHERE idProducto = :id");
		
		$producto->bindParam(":id", $id, PDO::PARAM_INT);

		if ( $producto->execute() ) {
			$rta = borrarImagen($imagen);
		}


		header("location: " . BACK_END_URL . "/?rta=" . $rta);
	}

	function borrarImagen($i){
		if($i != ""){
			if(unlink(UPLOAD_PATH_RELATIVE.$i)){
				return "0x010";
			} else {
				return "0x011";
			}
		} 

		return "0x010";

	}

	function ObtenerProducto($id = 0){
		$producto = array(
			"idProducto" => "",
			"Nombre" => "",
			"Precio" => "",
			"Marca" => "",
			"Categoria" => "",
			"Presentacion" => "",
			"Stock" => "",
			"imagen" => ""
		);
		if( $id != 0 ) {
			global $conexion;
			$id = $_GET["id"];
			$producto = $conexion->prepare("SELECT * FROM productos WHERE idProducto = :id");
			$producto->bindParam(":id", $id, PDO::PARAM_INT);
			if ( $producto->execute() ) {
				$producto = $producto->fetch();
			}
		}
		return $producto;
	}
?>