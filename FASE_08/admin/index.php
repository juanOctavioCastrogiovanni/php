<?php
	if ( isset( $_GET["page"] ) ) {
		$page = $_GET["page"];
	} else {
		$page = "panel";
	}
	require_once("functions.php");
	include("../header.php");
?>
<section id="page">
	<?php CargarPagina( $page ); ?>
</section>
<?php include("../footer.php"); ?>