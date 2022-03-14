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
				$mensaje = "Error al subir la imagen.";
			break;

			case '0x013':
				$mensaje = "Usuario ya registrado";
			break;

			case '0x014':
				$mensaje = "Registro correcto! Revise su email para activar su cuenta.";
			break;

			case '0x015':
				$mensaje = "Error en la registración, intente de nuevo";
			break;

			case '0x016':
			case '0x017':
				$mensaje = "Error de activación, intente de nuevo";
			break;

			case '0x018':
				$mensaje = "Su cuenta se ha activado correctamente!";
			break;

			case '0x019':
				$mensaje = "Usuario o contraseña incorrecta";
			break;

			case '0x020':
				$mensaje = "Ingreso exitoso!";
			break;

			case '0x021':
				$mensaje = "Sesión finalizada!";
			break;

			case '0x022':
				$mensaje = "Revise su casilla de e-mail para recuperar su cuenta";
			break;

			case '0x023':
				$mensaje = "Error, e-mail no valido o inexistente";
			break;

			case '0x024':
				$mensaje = "Clave actualizada satisfactoriamente!";
			break;

			case '0x025':
				$mensaje = "Error, contraseña invalida!";
			break;

			case '0x026':
				$mensaje = "Error, no se pudo actualizar su contraseña";
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
	
	//Funciones del Back-End
	function CrearProducto($nombre, $precio, $marca, $categoria, $presentacion, $stock, $imagen){
		global $conexion;
		$rta = "0x007";
		$directorio = UPLOADS . "/" . $imagen["name"];

		if( move_uploaded_file( $imagen["tmp_name"], $directorio ) == true ){
			$producto = $conexion->prepare("INSERT INTO productos (Nombre, Precio, Marca, Categoria, Presentacion, Stock, Imagen) VALUES (:nombre, :precio, :marca, :categoria, :presentacion, :stock, :imagen)");

			$producto->bindParam(":nombre", $nombre, PDO::PARAM_STR);
			$producto->bindParam(":precio", $precio, PDO::PARAM_STR);
			$producto->bindParam(":marca", $marca, PDO::PARAM_INT);
			$producto->bindParam(":categoria", $categoria, PDO::PARAM_INT);
			$producto->bindParam(":presentacion", $presentacion, PDO::PARAM_STR);
			$producto->bindParam(":stock", $stock, PDO::PARAM_INT);
			$producto->bindParam(":imagen", $imagen["name"], PDO::PARAM_STR);

			if ( $producto->execute() ) {
				$rta = "0x006";
			}
		} else {
			$rta = "0x012";
		}
		header("location: " . BACK_END_URL . "/?rta=" . $rta);
	}
	
	function ActualizarProducto($id, $nombre, $precio, $marca, $categoria, $presentacion, $stock,  $imagen, $imagenActual){
		global $conexion;
		$rta = "0x009";

		if( $imagen["error"] == 0 ){
			$directorio = UPLOADS . "/" . $imagen["name"];
			if( move_uploaded_file( $imagen["tmp_name"], $directorio ) == true ){
				$sqlImagen = $imagen["name"];
				unlink( UPLOADS . "/" . $imagenActual );

			}
		} else {
			$sqlImagen = $imagenActual;
		}

		$producto = $conexion->prepare("UPDATE productos SET Nombre = :nombre, Precio = :precio, Marca = :marca, Categoria = :categoria, Presentacion = :presentacion, Stock = :stock, Imagen = :imagen WHERE idProducto = :id");
					
		$producto->bindParam(":id", $id, PDO::PARAM_INT);
		$producto->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$producto->bindParam(":precio", $precio, PDO::PARAM_STR);
		$producto->bindParam(":marca", $marca, PDO::PARAM_INT);
		$producto->bindParam(":categoria", $categoria, PDO::PARAM_INT);
		$producto->bindParam(":presentacion", $presentacion, PDO::PARAM_STR);
		$producto->bindParam(":stock", $stock, PDO::PARAM_INT);
		$producto->bindParam(":imagen", $sqlImagen, PDO::PARAM_INT);

		if ( $producto->execute() ) {
			$rta = "0x008";
		}
		header("location: " . BACK_END_URL . "/?rta=" . $rta);
	}
	
	function BorrarProducto($id, $imagenActual){
		global $conexion;
		$rta = "0x011";
		$id = $_POST["id"];
		$producto = $conexion->prepare("DELETE FROM productos WHERE idProducto = :id");
		
		$producto->bindParam(":id", $id, PDO::PARAM_INT);

		if ( $producto->execute() ) {
			$rta = "0x010";
			unlink( UPLOADS . "/" . $imagenActual );
		}
		header("location: " . BACK_END_URL . "/?rta=" . $rta);
	}
	
	function ObtenerProducto($id = 0){
		$producto = array(
			"idProducto" => "",
			"Nombre" => "",
			"Precio" => "",
			"Marca" => "",
			"Categoria" => "",
			"Presentacion" => "",
			"Stock" => ""
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
	
	function ListarProductos($pagina = 0, $limite = 10){ ?>
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
			global $conexion;
			$posicion = ($pagina - 1) * $limite;
			//$productos = $conexion->prepare("SELECT * FROM Productos");
			$productos = $conexion->prepare("SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Stock, P.Imagen, M.Nombre AS Marca, C.Nombre AS Categoria FROM productos AS P INNER JOIN marcas AS M ON P.Marca = M.idMarca INNER JOIN categorias AS C ON P.Categoria = C.idCategoria LIMIT :posicion, :filas");
			$productos->bindParam(":posicion", $posicion, PDO::PARAM_INT);
			$productos->bindParam(":filas", $limite, PDO::PARAM_INT);
			$productos->execute();
			while ( $producto = $productos->fetch() ) {
			?>
			<tr>
				<td><img style="max-width:100px" src="<?php echo UPLOADS_URL . "/" . $producto["Imagen"]; ?>"></td>
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
	<?php
		MostrarPaginador($pagina, $limite);
	}

	function MostrarPaginador($pagina = 0, $limite = 10){
		global $conexion;
		$productos = $conexion->prepare("SELECT COUNT(*) FROM productos");
		$productos->execute();
		$total_filas = $productos->fetchColumn();		

		//Empezamos la paginacion desde cero
		$posicion = ($pagina - 1) * $limite;

		//Aqui obtenemos el numero de paginas que vamos a mostrar
		$paginas_total = ceil($total_filas / $limite);
?>
			<ul id="paginador">
				<?php if ($pagina != 1) : ?>
					<li><a href="<?php echo BACK_END_URL . "?p=" . ($pagina - 1); ?>">Anterior</a></li>
				<?php endif; ?>

				<?php 
					for ($i=1; $i <= $paginas_total; $i++) { 
						
						if ($pagina == $i) {
							$href = "#";
						} else {
							$href = BACK_END_URL . "/?p=".$i;
						}
						echo "<li><a href='".$href."'>".$i."</a></li>\n";
					}
				 ?>
				<?php if ($pagina != $paginas_total) : ?>
					<li><a href="<?php echo BACK_END_URL . "/?p=" . ($pagina + 1); ?>">Siguiente</a></li>
				<?php endif; ?>
			</ul>
<?php
	}
	
	function registrarUsuario($nombre, $apellido, $email, $pass){
		global $conexion;
		$rta = "0x013";
		$usuario = $conexion->prepare("SELECT * FROM usuarios WHERE email = :email");
		$usuario->bindParam(":email", $email, PDO::PARAM_STR);
		$usuario->execute();

		if ( $usuario->rowCount() == 0 ) {

			$hash = password_hash($pass, PASSWORD_DEFAULT);
			
			$string = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789ª!·$%&/()=?¿*^¨ç_:;\|@#~€¬][}{}]";
			$clave = str_shuffle( $string );
			$clave = md5( $clave );

			$usuario = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, email, pass, activacion) VALUES (:nombre, :apellido, :email, :pass, :activacion)");

			$usuario->bindParam(":nombre", $nombre, PDO::PARAM_STR);
			$usuario->bindParam(":apellido", $apellido, PDO::PARAM_STR);
			$usuario->bindParam(":email", $email, PDO::PARAM_STR);
			$usuario->bindParam(":pass", $hash, PDO::PARAM_STR);
			$usuario->bindParam(":activacion", $clave, PDO::PARAM_STR);
				
			if ( $usuario->execute() ) {
				$url_activacion = BACK_END_URL . "/";
				$url_activacion.= "usuario.php";
				$url_activacion.= "?u=" . $email;
				$url_activacion.= "&k=" . $clave;
				$url_activacion.= "&action=activeUser";

				$cuerpo = "<h1>Bienvenido a ComercioIT</h1>";
				$cuerpo.= "<br>";
				$cuerpo.= "Nombre: " . $nombre;
				$cuerpo.= "<br>";
				$cuerpo.= "Apellido: " . $apellido;
				$cuerpo.= "<br>";
				$cuerpo.= "Usuario: " . $email;
				$cuerpo.= "<br>";
				$cuerpo.= "<p>Por favor, active su cuenta para operar en la plataforma</p>";
				$cuerpo.= "<a style='background-color:blue;color:white;display:block;padding:10px' href='".$url_activacion."'>ACTIVAR MI CUENTA</a>";

				$cabecera = "From: no-reply@" . $_SERVER["SERVER_NAME"] . "\r\n";
				$cabecera.= "MIME-Version: 1.0" . "\r\n";
				$cabecera.= "Content-Type: text/html; charset=utf-8" . "\r\n";

				//mail( $email, "Alta de nuevo Usuario", $cuerpo, $cabecera );
				echo $cuerpo;
				die();
				$rta = "0x014";
			} else {
				$rta = "0x015";
			}
		}
		header("location: " . BACK_END_URL . "/?page=registro&rta=" . $rta);
	}
	
	function activarUsuario($email, $clave){
		global $conexion;
		$rta = "0x016";
		$usuario = $conexion->prepare("SELECT * FROM usuarios WHERE email = :email AND activacion = :activacion");
		$usuario->bindParam(":email", $email, PDO::PARAM_STR);
		$usuario->bindParam(":activacion", $clave, PDO::PARAM_STR);

		if ( $usuario->execute() ) {
			
			$usuario = $conexion->prepare("UPDATE usuarios SET estado = 1 WHERE email = :email");
			$usuario->bindParam(":email", $email, PDO::PARAM_STR);

			if ( $usuario->execute() ) {
				$rta = "0x018";
			} else {
				$rta = "0x017";
			}

		}
		header("location: " . BACK_END_URL . "/?page=ingreso&rta=" . $rta);
	}

	function iniciarSesion($email, $pass){
		global $conexion;
		
		$rta = "0x019";
		$ruta = "ingreso";

		$usuario = $conexion->prepare("SELECT * FROM usuarios WHERE email = :email AND estado = 1");
		$usuario->bindParam(":email", $email, PDO::PARAM_STR);

		if ( $usuario->execute() && $usuario->rowCount() > 0 ) {

			$usuario = $usuario->fetch();

			if (password_verify($pass, $usuario["Pass"])) {
				session_start();
				$_SESSION["Usuario"] = array(
					"Nombre" => $usuario["Nombre"],
					"Apellido" => $usuario["Apellido"],
					"Email" => $usuario["Email"]
				);
				$rta = "0x020";
				$ruta = "panel";
			}
		}
		header("location: " . BACK_END_URL . "/?page=".$ruta."&rta=" . $rta);
	}

	function cerrarSesion(){
		$rta = "0x021";
		session_start();
		setcookie(session_name(), '', time() - 42000, '/'); 
		unset( $_SESSION );
		session_destroy();
		header("location: " . BACK_END_URL . "/?page=ingreso&rta=" . $rta);
	}

	function recuperarClave( $email ){
		global $conexion;
		$rta = "0x023";
		$usuario = $conexion->prepare("SELECT * FROM usuarios WHERE email = :email AND estado = 1");
		$usuario->bindParam(":email", $email, PDO::PARAM_STR);

		if ( $usuario->execute() ) {

			$string = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789ª!·$%&/()=?¿*^¨ç_:;\|@#~€¬][}{}]";
			$clave = str_shuffle( $string );
			$clave = md5( $clave );

			$usuario = $conexion->prepare("UPDATE usuarios SET activacion = :activacion WHERE email = :email");
			$usuario->bindParam(":email", $email, PDO::PARAM_STR);
			$usuario->bindParam(":activacion", $clave, PDO::PARAM_STR);

			if ( $usuario->execute() ) {
				$url_recupero = BACK_END_URL . "/";
				$url_recupero.= "?page=reseteo";
				$url_recupero.= "&u=" . $email;
				$url_recupero.= "&k=" . $clave;

				$cuerpo = "<h1>Recupero de Cuenta en ComercioIT</h1>";
				$cuerpo.= "<br>";
				$cuerpo.= "Usuario: " . $email;
				$cuerpo.= "<br>";
				$cuerpo.= "<p>Por favor, haga click para recuperar su cuenta.</p>";
				$cuerpo.= "<a style='background-color:blue;color:white;display:block;padding:10px' href='".$url_recupero."'>RECUPERAR MI CUENTA</a>";

				$cabecera = "From: no-reply@" . $_SERVER["SERVER_NAME"] . "\r\n";
				$cabecera.= "MIME-Version: 1.0" . "\r\n";
				$cabecera.= "Content-Type: text/html; charset=utf-8" . "\r\n";

				//mail( $email, "Alta de nuevo Usuario", $cuerpo, $cabecera );
				echo $cuerpo;
				die();
				$rta = "0x022";
			}
			header("location: " . BACK_END_URL . "/?page=ingreso&rta=" . $rta);
			
		}
	}

	function guardarClave( $email, $pass, $clave ){
		global $conexion;
		$rta = "0x026";
		$usuario = $conexion->prepare("SELECT * FROM usuarios WHERE email = :email AND activacion = :activacion");
		$usuario->bindParam(":email", $email, PDO::PARAM_STR);
		$usuario->bindParam(":activacion", $clave, PDO::PARAM_STR);

		if ( $usuario->execute() ) {
			
			$hash = password_hash($pass, PASSWORD_DEFAULT);

			$usuario = $conexion->prepare("UPDATE usuarios SET pass = :pass WHERE email = :email");
			$usuario->bindParam(":email", $email, PDO::PARAM_STR);
			$usuario->bindParam(":pass", $hash, PDO::PARAM_STR);

			if ( $usuario->execute() ) {
				$rta = "0x024";
			} else {
				$rta = "0x025";
			}

		}
		header("location: " . BACK_END_URL . "/?page=ingreso&rta=" . $rta);
	}

	function validarSesion($estado = false){
		$ruta = $estado ? "panel" : "ingreso";
		if( isset( $_SESSION["Usuario"] ) == $estado ) {
			header("location: " . BACK_END_URL . "/?page=" . $ruta);
		}
	}
?>