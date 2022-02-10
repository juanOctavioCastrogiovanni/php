<?php
    require "./menu.php";
    require "./paises.php";
    require "./db.php";

    \db\conectar('mysql:host=localhost;dbname=mundo_db','root','');

    $paginas = isset($_GET['p']) ? $_GET['p']:'';

    switch(strtolower($paginas)){
        case 'listado': $paises = \pais\listar();
                        require "./listado.php";
                        break;

        case 'nuevo':   if(isset($_POST['pais'])){
                                $paisSeleccionado = $_POST['pais'];
                        }
                        $paises = \pais\listar();
                        $error = '';
                        $agregar = array('');
                
                        if(isset($paisSeleccionado)){
                            foreach ($paises as $pais){
                                if($pais['Pais']==$paisSeleccionado){
                                    $error = "<p>Ese pais ya se encuentra creado</p>";                      
                                    break;    
                                }
                            }      
                        }

                        if($error==''){
                           $resultado = \pais\nuevo($paisSeleccionado);
                           if($resultado){
                            if(isset($_POST['estado'])){
                                $completo = \pais\nuevo($_POST['estado'],$resultado)); 
                                if($completo){
                                    $agregar[] = 'Se ha agregado un nuevo estado '. $_POST['estado'];
                                }
                            }
                            require "./crearEstado.php";
                           }
                        }
                        require "./crearPais.php";
                        break;
        case 'borrar':  if(isset($_GET['idEstado'])){
                            $borrado = \pais\borrar($_GET['idEstado'],FALSE,"id");
                        } else{
                            $borrado = \pais\borrar($_GET['idPais'],TRUE, "ubicacionpaisid");
                        }
                        
                            if($borrado ){
                                echo "<h2>Se ha borrado el pais correctamente</h2>";
                          
                        }
                        break;
        case 'editar': 
                        if($_SERVER["REQUEST_METHOD"]=="POST"){
                             $resultado = \pais\actualizar($_POST);
                                if($resultado){
                                 echo "<h2>Se ha editado correctamente</h2>";
                                }
                          }
                        
                        if(isset($_GET['id'])){
                            $pais = \pais\buscar($_GET['id']);  
                            require "./editar.php";
                        }

                        if(isset($_GET['idEstado'])||isset($_GET['idPais'])){
                            $pais   = isset($_GET['idPais']) ? \pais\busqueda($_GET['idPais'],'pais') : FALSE;  
                            $estado = isset($_GET['idEstado']) ? \pais\busqueda($_GET['idEstado'],'estado') : FALSE;
                            require "./editarDetalle.php";
                        }
                        break;
        case 'detalle': 
                       if(isset($_GET['id'])){
                            $pais = \pais\buscar($_GET['id']);         
                        } else {
                            $pais = 'No se encontro';
                        }   

                        require "./detalle.php";
                        break;
        case '':        
                        require "./home.php";
                        break;

    }
?>

</body>
</html>