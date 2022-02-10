
<h1>Se ha creado el pais con exito</h1>
<h2>Por favor escriba un nuevo estado</h2>
<?php 
    foreach ($agregar as $a){
        echo $a;
    }

?>
<form method="POST" action="">
            <input type="text" name="estado">
            <input type="hidden" name="p" value="nuevo">
            <input type="hidden" name="id" value="<?php echo $resultado ?>">
        <button type="submit">Crear</button>
</form>