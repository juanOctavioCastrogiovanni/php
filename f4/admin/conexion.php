<?php
    namespace conexion{
        function conectar($dls=NULL, $nombreUsuario='root', $password=''){
            static $conexion = NULL;
            if($conexion){
                return $conexion;
            }

            $conexion = new \PDO($dls,$nombreUsuario,$password);
            return $conexion;
        }


        function BusquedaDeProductos($id=NULL){
                    
                    $pdo = conectar();
                        $flag = FALSE;

                        if($id==NULL){
                            $sql = 'SELECT productos.idProducto,productos.Nombre, Precio, Presentacion AS Memoria, Stock, marcas.Nombre AS Marca, categorias.Nombre AS Categoria FROM `productos` INNER JOIN marcas ON marcas.idMarca=productos.Marca INNER JOIN categorias ON productos.Categoria = categorias.idCategoria';
                        } else if ($id){
                            $sql = 'SELECT productos.idProducto,productos.Nombre, Precio, Presentacion AS Memoria, Stock, marcas.Nombre AS Marca, productos.Marca AS idMarca, categorias.Nombre AS Categoria, productos.Categoria AS idCategoria FROM `productos` INNER JOIN marcas ON marcas.idMarca=productos.Marca INNER JOIN categorias ON productos.Categoria = categorias.idCategoria WHERE idProducto=:id';
                            $flag = TRUE;
                        }

                    $stmt = $pdo -> prepare($sql);
                        if($flag){
                            $stmt -> bindValue(':id',$id);

                            if(!$stmt -> execute()){
                                return FALSE;
                            }
                    
                            return $stmt -> fetch();
                        }
                        
                    if(!$stmt -> execute()){
                        return FALSE;
                    }

                    return $stmt -> fetchAll(\PDO::FETCH_ASSOC);
        }

        function listar($tipo){
        
            $pdo = conectar();

            $sql = "SELECT * FROM ". $tipo; 
    
            $stmt = $pdo -> prepare($sql);
                                
            if(!$stmt -> execute()){
                return FALSE;
            }
    
            return $stmt -> fetchAll(\PDO::FETCH_ASSOC);
        }


        function CrearProducto($datos){

            $datos = limpiar($datos,FALSE);           

            $estructura = array('Nombre','Precio','Marca','Categoria','Stock','Presentacion');

            if(array_diff(array_keys($datos),$estructura)){
                return NULL;
            }
            
          

            if(!insert('productos',$datos)){
                return FALSE;
            }
            
            $pdo = conectar();
            return $pdo -> lastInsertId();
           
            
        }

        function insert($tabla,$datos){

                $sql = "INSERT INTO $tabla SET ";
                
                $insert = array();

                foreach ($datos as $clave => $valor){
                    $insert[] = "$clave=:$clave";
                }
                
                $sql = sprintf("%s %s", $sql, implode(',',$insert));

                $pdo = conectar();

                $stmt = $pdo -> prepare($sql);

                foreach ($datos as $clave => $valor){
                    $stmt -> bindValue(":$clave",$valor);
                }

                return $stmt -> execute();

        }


        function ActualizarProducto($producto){

            $id = $producto['idProducto'];
            
            $producto = limpiar($producto,TRUE);
            
            $estructura = array('idProducto','Nombre','Precio','Marca','Categoria','Stock','Presentacion');

            if(array_diff(array_keys($producto),$estructura)){
                return NULL;
            }

            if(!update('productos',$producto,$id)){
                return FALSE;
            }



            return $id;
        }


        function update($table, $datos,$id){

            $sql = "UPDATE $table SET ";
                
            $insert = array();

            foreach ($datos as $clave => $valor){
                $insert[] = "$clave=:$clave";
            }
            
            $sql = sprintf("%s %s WHERE idProducto=:idProducto ", $sql, implode(',',$insert));

            $pdo = conectar();

            $stmt = $pdo -> prepare($sql);

            $stmt -> bindValue(":idProducto",$id);

            foreach ($datos as $clave => $valor){
                $stmt -> bindValue(":$clave",$valor);
            }

            return $stmt -> execute();

        }

        function limpiar($datos,$bandera){

            foreach ($datos as $clave => $valor){
                if($bandera){
                    if($clave == 'idProducto'){
                        unset($datos[$clave]);
                    }    
                }

                if($clave == 'action'){
                    unset($datos[$clave]);
                }

                if($clave=='Marca' || $clave=='Categoria'){
                        $datos[$clave] = (int)$valor;
                    }

                if($clave=='Memoria'){
                    
                    $datos['Presentacion'] = $valor;
                    unset($datos[$clave]);
                    
                }
            }

            return $datos;
        }

        function BorrarProducto($id){
            
            if(!delete($id)){
                return FALSE;
            }

            return TRUE;

        }

        function delete($id){
            $sql = "DELETE FROM productos WHERE idProducto = $id";
            
            $pdo = conectar();

            $stmt = $pdo -> prepare($sql);
            
            return $stmt -> execute();

        }
        
    }
?>