<?php
	validarSesion(true);
	if( isset($_GET["u"]) && isset($_GET["k"]) ){
		$action = "savePass";
		$email = $_GET["u"];
		$clave = $_GET["k"];
	} else {
		$action = "recoveryUser";
	}

?>
<div class="account_grid">
	<div class="login-right">
		<h3>RECUPERAR CUENTA</h3>
		<form action="<?php echo BACK_END_URL . "/usuario.php?action=" . $action; ?>" method="post">
		<?php if( $action == "recoveryUser" ) { ?>
		<div>
			<span>E-Mail:</span>
			<input type="text" name="email"> 
		</div>
		<?php } else { ?>
		<div>
			<span>Ingrese una Nueva Contraseña:</span>
			<input type="password" name="pass">
			<input type="hidden" name="email" value="<?php echo $email; ?>"> 
			<input type="hidden" name="clave" value="<?php echo $clave; ?>"> 
		</div>
		<?php } ?>
			<input type="submit" value="Enviar">
		</form>
	</div>	
	<div class="clearfix"></div>
</div>