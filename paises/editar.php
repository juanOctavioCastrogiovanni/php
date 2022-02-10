

<h1>Pais elegido es <?php 

foreach($pais as $p){
    echo $p['Pais']."&nbsp&nbsp&nbsp<a href='?p=editar&idPais=".$p['id']."'>Editar</a>";

    break;
}

?></h1>

 <?php 

$contador = 0; 
foreach($pais as $p){
    echo "<h3>Estado ". $contador.": ".$p['Estado']."&nbsp&nbsp&nbsp<a href='?p=editar&idPais=".$p['id']."'>Editar</a>&nbsp&nbsp&nbsp<a href='?p=borrar&idPais=".$p['id']."&idEstado=".$p['idEstado']."'>borrar</a></h3>";
    $contador++;
}

?>    


