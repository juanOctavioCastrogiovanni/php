<?php
	require("conexion.php");
	
	//Valido que haya una accion a realizar
	if( isset( $_GET["action"] ) ){
		$action = $_GET["action"];
	} else {
		$action = "add";
	}

	//Valido que tipo de peticion invoca al modulo
	if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
		//Aca se deben procesar los datos del formulario ejecutado
		require("../init.php");
		require("functions.php");
		
		switch ($action) {
			case 'add':
				$nombre = $_POST["nombre"];
				$precio =  $_POST["precio"];
				$marca =  $_POST["marca"];
				$categoria =  $_POST["categoria"];
				$presentacion =  $_POST["presentacion"];
				$stock =  $_POST["stock"];
				$imagen = $_FILES["imagen"];
				
				CrearProducto($nombre, $precio, $marca, $categoria, $presentacion, $stock, $imagen);
			break;
			
			case 'update':
				$id = $_POST["id"];
				$nombre = $_POST["nombre"];
				$precio =  $_POST["precio"];
				$marca =  $_POST["marca"];
				$categoria =  $_POST["categoria"];
				$presentacion =  $_POST["presentacion"];
				$stock =  $_POST["stock"];

				$imagen = $_FILES["imagen"];
				$imagenActual = $_POST["imagenActual"];
				
				ActualizarProducto($id, $nombre, $precio, $marca, $categoria, $presentacion, $stock, $imagen, $imagenActual);
			break;
			
			case 'delete':
				$id = $_POST["id"];
				$imagenActual = $_POST["imagenActual"];
				BorrarProducto($id, $imagenActual);
			break;
		}

	} else {
		//Preparar el formulario para: Agregar - Modificar - Eliminar

		switch ($action) {
			case 'add':
				$btn = "Agregar";
				$status = null;
				$producto = ObtenerProducto();
			break;
			
			case 'update':
				$id = $_GET["id"];
				$btn = "Actualizar";
				$status = null;
				$producto = ObtenerProducto( $id );
			break;

			case 'delete':
				$id = $_GET["id"];
				$btn = "Eliminar";
				$status = "disabled";
				$producto = ObtenerProducto( $id );
			break;
		}
	}
?>
<div class="main">
<form action="admin/producto.php?action=<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	Nombre:
	<br>
	<input type="text" name="nombre" value="<?php echo $producto["Nombre"]; ?>" <?php echo $status; ?>>
	<br>
	Precio:
	<br>
	<input type="text" name="precio" value="<?php echo $producto["Precio"]; ?>" <?php echo $status; ?>>
	<br>
	Marca:
	<br>
	<select name="marca" <?php echo $status; ?>>
		<option>Elija una marca...</option>
		<?php
			$marcas = $conexion->prepare("SELECT * FROM marcas");
			$marcas->execute();
			while ( $marca = $marcas->fetch() ) {
		?>
			<option value="<?php echo $marca["idMarca"]; ?>" <?php if($marca["idMarca"] == $producto["Marca"]) echo "selected" ?>><?php echo $marca["Nombre"]; ?></option>

		<?php } ?>
	</select>
	<br>
	Categoria:
	<br>
	<select name="categoria" <?php echo $status; ?>>
		<option>Elija una categoria...</option>
		<?php
			$categorias = $conexion->prepare("SELECT * FROM categorias");
			$categorias->execute();
			while ( $categoria = $categorias->fetch() ) {
		?>
			<option value="<?php echo $categoria["idCategoria"]; ?>" <?php if($categoria["idCategoria"] == $producto["Categoria"]) echo "selected" ?>><?php echo $categoria["Nombre"]; ?></option>

		<?php } ?>
	</select>
	<br>
	Presentacion:
	<br>
	<input type="text" name="presentacion" value="<?php echo $producto["Presentacion"]; ?>" <?php echo $status; ?>>
	<br>
	Stock:
	<br>
	<input type="text" name="stock" value="<?php echo $producto["Stock"]; ?>" <?php echo $status; ?>>
	<br>
<?php if( !empty( $producto["Imagen"] ) ) : ?>
	<br>
	<div style="width:100px">
		<img src="<?php echo UPLOADS_URL . "/" . $producto["Imagen"]; ?>" style="max-width:100%">
	</div>
	<br>
<?php endif; ?>
	Imagen:
	<br>
	<input type="file" name="imagen">
	<br>
	<br>
	<input type="submit" value="<?php echo $btn; ?>">
<?php if( isset($id) ){ ?>
	<input type="hidden" name="id" value="<?php echo $producto["idProducto"]; ?>">
	<input type="hidden" name="imagenActual" value="<?php echo $producto["Imagen"]; ?>">
<?php } ?>
</form>
</div>