<?php

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email'])){
        include "./functions.php";
        if($_POST['tipo']=="registro"){
            registrarUsuario($_POST);
        }
        
        if($_POST['tipo'] == "ingreso"){
            if(iniciarSesion($_POST['email'],$_POST['pass'])){
                header("location: ./?page=panel&rta=0x020");
            } else {
                header("location: ./?page=panel&rta=0x019");
            }
        }
    } 
    
    if(isset($_GET['u'])){
        include "./functions.php";
            $datos = crearNuevoUsuario(1,$_GET['u'],NULL);
            crearSesion($datos['nombre'], $datos['apellido'], $datos['email']);
            header("location: ./?page=panel&rta=0x020");
    }    

    if(isset($_GET['exit'])&&$_GET['exit'] === "exit"){
        setcookie(session_name(),NULL);

        session_unset();
        session_destroy();
        header("location: ./?page=panel");
    }
    
?>
