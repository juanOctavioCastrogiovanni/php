<?php
require "./functions.php";
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email'])){
        if($_POST['tipo']=="registro"){
            registrarUsuario($_POST);
        }

        if($_POST['tipo'] == "registro"){
            if(iniciarSesion($_POST['email'],$_POST['pass'])){
                crearSession($_POST['nombre'],$_POST['apellido'],$_POST['email']);
                header("location: ./?page=panel&rta=0x020");
            } else {
                header("location: ./?page=panels&rta=0x019");
            }
        }
    } 

    if(isset($_GET['u'])){
            $datos = crearNuevoUsuario(1,$_GET['u'],NULL);
            crearSession($datos['nombre'], $datos['apellido'], $datos['email']);
            header("location: ./?page=panel&rta=0x020");
    }    

    if(isset($_GET['exit'])&&$_GET['exit'] == "exit"){
        setcookie(session_name(),NULL);

        session_unset();
        session_destroy();
    }
    
?>

REVISAR CERRAR SESSION ERROR