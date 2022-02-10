<?php
    include "./conexion.php";
    include "./validacion.php";
    $conexion = \conexion\conectar("mysql:host=localhost;dbname=comercioit",'root','');  

if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['action'])&&$_POST['action']=='add'){
            $correcto = TRUE;

            \validar\validacionProducto($_POST,$correcto);
            
            if($correcto){
                $nuevo = \conexion\CrearProducto($_POST);
                
                if($nuevo){
                    header('location: ./?page=producto&rta=0x008');
                } else {
                    header('location: ./?page=producto&rta=0x008');
                }
            }
        
        } else if (isset($_POST['action'])&&$_POST['action']=='update'){
            
            $actualizar = TRUE;
            \validar\validacionProducto($_POST,$actualizar);


            if($actualizar){
                $actualizado = \conexion\ActualizarProducto($_POST);
                $producto = \conexion\BusquedaDeProductos($actualizado); 

                if($actualizado){                    
                    header('location: ./?page=producto&rta=0x008');
                } else {
                    header('location: ./?page=producto&rta=0x009');
                }
            }
        }
    }

    ?>