<form method="POST" action="">
<?php

if($pais){
    foreach($pais as $p){
        echo "<input type='text' name='nombre' value='".$p['paisnombre']."'><input type='hidden' name='idPais' value='".$p['id']."'><button type='submit'>Enviar</button>";
    }
}


if($estado){
    foreach($estado as $e){
        echo "<input type='text' name='nombre' value='".$e['estadonombre']."'><input type='hidden' name='idEstado' value='".$e['id']."'><button type='submit'>Enviar</button>";
    }
}
?>
</form>