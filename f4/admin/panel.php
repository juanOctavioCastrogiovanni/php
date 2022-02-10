<?php 
      include "./conexion.php";
      include "./validacion.php";
      include "../functions.php";
      $conexion = \conexion\conectar("mysql:host=localhost;dbname=comercioit",'root','');  
      $productos = \conexion\BusquedaDeProductos();  
?>

<h1>Listado de productos</h1>

<table>
    <thead>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Marca</th>
        <th>Categoria</th>
        <th>Memoria</th>
        <th>Stock</th>
    </thead>
    <tbody>
    <?php 
    foreach($productos as $producto){
    echo "<tr>"; 
        echo "<td>".$producto['Nombre']."</td>";
        echo "<td>".$producto['Precio']."</td>";
        echo "<td>".$producto['Marca']."</td>";
        echo "<td>".$producto['Categoria']."</td>";
        echo "<td>".$producto['Memoria']."</td>";
        echo "<td>".$producto['Stock']."</td>";
        echo "<td><a href='admin/?page=producto&action=update&id=".$producto['idProducto']."'>Actualizar</a></td>";
        echo "<td><a href='admin/?page=producto&action=delete&id=".$producto['idProducto']."'>Eliminar</a></td>";
    echo "</tr>";
    }
    ?>
    </tbody>
</table>
<form method="GET" action="">
    <input type="hidden" name="page" value="producto"></input>
    <input type="hidden" name="action" value="add"></input>
    <button>Crear nuevo producto</button>
</form>
<?php 
    $bandera = FALSE;

    if(isset($_GET['action'])){
        if($_GET['action']=='delete'){
            $eliminado = \conexion\BorrarProducto($_GET['id']);
            if($eliminado){
                echo "<h2>El producto se ha eliminado correctamente.</h2>";
            } else {
                echo "<h2>El producto NO se ha eliminado correctamente.</h2>";
            }
        }
        
    } 
    
    if (isset($_GET['rta'])){
        echo MostrarMensaje($_GET['rta']);
    }
        

    if(isset($_GET['page']) && $_GET['page']==='producto'){
        if(isset($_GET['action'])){
            $marcas = \conexion\listar('marcas');
            $categorias = \conexion\listar('categorias');
            $action = $_GET['action'];
            $update = $_GET['action']=='update' ? TRUE : FALSE;
            if(isset($_GET['id'])){
                $producto = \conexion\BusquedaDeProductos($_GET['id']); 
                
            }
                if (isset($_GET['rta'])){
                echo MostrarMensaje($_GET['rta']);
                }
            require "./producto.php";
        } 

    }
?>