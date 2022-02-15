	<div class="register">
		<div class="register-top-grid">
			<h3>NUEVO USUARIO</h3>
			<?php 
			if (isset( $_GET["rta"]) ) {
				echo MostrarMensaje( $_GET["rta"] );
			}
		?>
			<form action="admin/usuario.php" method="post">
				<div class="mation">
					<input type="hidden" name="tipo" value="registro">
					<span>Nombre: <label>*</label></span>
					<input type="text" name="nombre"> 
					<span>Apellido: <label>*</label></span>
					<input type="text" name="apellido"> 
					<span>E-Mail: <label>*</label></span>
					<input type="text" name="email">
					<span>Contraseña: <label>*</label></span>
					<input type="password" name="pass">
					<div class="register-but">
						<input type="submit" value="Registrarme">
					</div>
				</div>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>