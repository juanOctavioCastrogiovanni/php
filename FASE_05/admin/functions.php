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

			case '0x013':
				$mensaje = "El mail ya se encuentra registrado";
			break;

			case '0x014':
				$mensaje = "Se ha enviado un correo a su casilla de correo electronico. Por favor active su cuenta";
			break;

			case '0x015':
				$mensaje = "Error";
			break;

			case '0x019':
				$mensaje = "No coincide clave con contraseña";
			break;

			case '0x020':
				$mensaje = "Se ha iniciado sesion";
			break;

			case '0x021':
				$mensaje = "Se ha cerrado sesion correctamente";
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
			if($producto["imagen"]){
				echo "<td style='width:20%;'><img style='width:70%;' src='" . UPLOAD_PATH . $producto['imagen']. "'></td>";
			} else {
				echo "<td><p> Este producto no posee una imagen </p></td>";
			}
			echo "<td>".$producto["Nombre"]."</td>";
			echo "<td>".$producto["Precio"]."</td>";
			echo "<td>".$producto["Marca"]."</td>";
			echo "<td>".$producto["Categoria"]."</td>";
			echo "<td>".$producto["Presentacion"]."</td>";
			echo "<td>".$producto["Stock"]."</td>";


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

	function registrarUsuario($usuario){
		if(validacionUsuario($usuario['email'])){
            header("location: ./?page=registro&rta=0x013");
        } else if(validacionUsuario($usuario['email']) === NULL){
            echo "Problema con la peticion a la base de datos";
        } else {
            crearNuevoUsuario(0,NULL,$usuario);
        }
	}

	function crearNuevoUsuario($estado, $email = NULL, $usuario = NULL){
		global $conexion;

		if($estado==0){
			$usuarios = $conexion->prepare("INSERT INTO usuarios (Nombre, Apellido, Email, Pass, Activacion, Estado) VALUES (:nombre, :apellido, :email, :pass, :activacion, :estado)");
			$contrasenia = password_hash($usuario['pass'] , PASSWORD_DEFAULT , [
				'cost' => 10]);
			
			$activacion = chr(random_int(65, 90)) . random_int(1000, 9999);
			
			//usar password_verify($password,$hash); para verificarlo

			// INSERT INTO usuarios (Nombre, Apellido, Email, Pass, Activacion, Estado) VALUES ("Pedro" , "El escamoso", "pedroelEscamoso@yahoo.com", "$2y$10$jg8x0SoMOpfRgxBwd2nMZeaBkMNAEgc6qUg8N22c.BTR5UlPD6zWu", "G9484", 0)

			$usuarios->bindValue(":nombre", $usuario['nombre']);
			$usuarios->bindValue(":apellido", $usuario['apellido']);
			$usuarios->bindValue(":email", $usuario['email']);
			$usuarios->bindValue(":pass", $contrasenia);
			$usuarios->bindValue(":activacion", $activacion);
			$usuarios->bindValue(":estado", $estado); 

			if ( $usuarios->execute() ) {
//usuario.php?u=GC@hotmail.com&k=P9500&action=activeUser
				$cuerpo = "<h1>ComercioIT - Datos de contacto</h1>";
				$cuerpo.= "<p><strong>Nombre:</strong> " . $usuario['nombre'] . "</p>";
				$cuerpo.= "<p><strong>E-Mail:</strong> " .  $usuario['email'] . "</p>";
				$cuerpo.= "<p><strong>Por favor da click en el boton del enlace con el codigo de activacion</strong></p>";
				$cuerpo.= "<p><strong><a href='usuario.php?u=".$usuario['email']."&k=$activacion&action=activeUser'</strong></p>";

				//3) Construir la cabecera del email
				$cabecera = "From: contacto@comercioit.com\r\n";
				$cabecera.= "MIME-Version: 1.0\r\n";
				$cabecera.= "Content-Type: text/html; charset=UTF-8\r\n";

				$destinatario = $usuario['Email'];

				$asunto = "Activacion de cuenta";

				//4) Enviar el email
				if ( mail($destinatario, $asunto, $cuerpo, $cabecera) === true ) {
					//echo "E-Mail enviado";
					header("location: ./?page=registro&rta=0x014");
				} else {
					//echo "E-Mail no enviado";
					header("location: ./?page=registro&rta=0x015");
				}
			} else {
				header("location: ./?page=registro&rta=0x015");
			}

		} else if($estado==1){
			if(activarUsuario($email)){
				FALTA RECUPERAR EL USUARIO PARA SACAR LOS DATOS NOMBRE, APELLIDO Y MAIL
				return array('nombre' => $usuario['nombre'],
							'apellido' => $usuario['apellido'],
							'email' => $usuario['email']);
			}
		}
	}

	function validarContrasenia($hash, $contrasenia){
		return password_verify($contrasenia,$hash);
	}

	function validacionUsuario($email,$contrasenia = NULL){
		global $conexion;
		$listaUsuarios = $conexion->prepare("SELECT * FROM usuarios");
		if($listaUsuarios->execute()){
			$usuarios = $listaUsuarios -> fetchAll();
			foreach($usuarios as $usuario){
				if($usuario['Email'] == $email&&$contrasenia){
					return validaContrasenia($usuario['pass'],$contrasenia) ? TRUE : FALSE;
				} else if ($usuario['Email'] == $email){
					return TRUE;
				}
			}

			return False;
		} 

		return NULL;
	}

	function activarUsuario($email){
		global $conexion;

		$usuario = $conexion -> prepare("UPDATE usuarios SET Estado = 1 WHERE Email = :email");
		$usuario -> bindValue(":email", $email);

		if($usuario -> execute()){
			return TRUE;
		} 

		return FALSE;
	}

	function iniciarSecion($email,$contrasenia){
		return validacionUsuario($email,$contrasenia);
	}

	function validarSesion($bandera){
		if($bandera){
			header("location: ./?page=panel");
		} 
	}

	function crearSession($nombre,$apellido,$email){
		session_start();

        $_SESSION['Nombre'] = $nombre; 
        $_SESSION['Apellido'] = $apellido; 
        $_SESSION['Email'] = $email;
	}
?>