<?php
require "./functions.php";
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email'])){
        if($_POST['tipo']=="registro"){
            registrarUsuario($_POST);
        }
    } 

    if(isset($_GET['u'])){
        crearNuevoUsuario(1,$_GET['u']);
    }
  
?>