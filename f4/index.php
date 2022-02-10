<?php
	if ( isset( $_GET["page"] ) ) {
		$panel = $_GET["page"];
	} else {
		$panel = "inicio";
	}
	require("./functions.php");
	include("./header.php");
?>
<section id="page">
	<?php CargarPagina( $panel ); ?>
</section>
<?php include("./footer.php"); ?>