<?php
require "./functions.php";
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email'])){
    if($_POST['tipo']=="registro"){
        registrarUsuario($_POST);
    }

} 
  
?>