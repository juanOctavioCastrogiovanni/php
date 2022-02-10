

<h1>Pais elegido es <?php 
$id = NULL;

foreach($pais as $p){
    echo $p['Pais'];
    $id = $p['id'];
    break;
}

?></h1>

 <?php 

$contador = 0; 
foreach($pais as $p){
    echo "<h3>Estado ". $contador.": ".$p['Estado']. "</h3>";
    $contador++;
}

?>    

<table>
    <tr>
        <td>
            <form method="DELETE" action="">
                <input type="hidden" name="p" value="borrar">
                <input type="hidden" name="idPais" value="<?php echo $id?>">
                <button type="submit">Borrar</button>
            </form>
        </td>

        <td>
            <form method="GET" action="">
                <input type="hidden" name="p" value="editar">
                <input type="hidden" name="id" value="<?php echo $id?>">
                <button type="submit">Editar</button>
            </form>
        </td>
    </tr>
</table>
