<?php

	function CargarPagina($pagina){
		$modulo = $pagina . ".php"; 
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
			case '0x008':
				$mensaje = "Registro agregado o modificado con exito";
			break;						
			case '0x009':
				$mensaje = "El registro tuvo un problema al modificarse en el servidor";
			break;
			case '0x010':
				$mensaje = "Tiene que seleccionar una marca y una categoria.";
			break;
			case '0x011':
				$mensaje = "El nombre tiene caracteres invalidos.";
			break;
			case '0x012':
				$mensaje = "El precio debe ser un numero.";
			break;
			case '0x013':
				$mensaje = "El campo memoria debe contener numeros seguidos de la letras GB.";
			break;
			case '0x014':
				$mensaje = "El stock debe estar escrito en numeros.";
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
					<h4><a href="./?page=producto"><?php echo $datos[4]; ?> - <?php echo $datos[1]; ?></a></h4>
					<p>Precio: $<?php echo $datos[2]; ?> - Presentacion: <?php echo $datos[5]; ?></p>
					<span>Stock: <?php echo $datos[3]; ?></span>
				</div>
			</div>
			<?php
    		}
    	}
    }

?>