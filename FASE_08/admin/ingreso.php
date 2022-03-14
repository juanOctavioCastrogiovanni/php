<?php validarSesion(true); ?>
<div class="account_grid">
<?php
	if (isset( $_GET["rta"]) ) {
		echo MostrarMensaje( $_GET["rta"] );
	}
?>
	<div class="login-right">
		<h3>INGRESO DE USUARIO</h3>
		<form action="<?php echo BACK_END_URL . "/usuario.php?action=loginUser"; ?>" method="post">
		<div>
			<span>E-Mail:</span>
			<input type="text" name="email"> 
		</div>
		<div>
			<span>Contraseña:</span>
			<input type="password" name="pass"> 
		</div>
			<input type="submit" value="Ingresar">
			<br>
			<a class="forgot" href="<?php echo BACK_END_URL . '/?page=reseteo'; ?>">¿Olvidaste tu contraseña?</a>
		</form>
	</div>	
	<div class=" login-left">
		<h3>¿NUEVO USUARIO?</h3>
		<a class="acount-btn" href="<?php echo BACK_END_URL . '/?page=registro'; ?>">Crear una cuenta</a>
	</div>
	<div class="clearfix"></div>
</div>