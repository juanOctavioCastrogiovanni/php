<?php
    namespace pais{
        function listar(){
            $sql = "SELECT id, paisnombre AS Pais FROM pais";           
            return \db\consulta($sql);
        }

        function buscar($id){
            $sql = "SELECT pais.id, paisnombre AS Pais, estadonombre AS Estado,estado.id AS idEstado FROM pais INNER JOIN estado ON pais.id = estado.ubicacionpaisid WHERE pais.id=:id ORDER BY estado.estadonombre ASC";
            return \db\consulta($sql,['id'=>$id]);
        }

        function busqueda($id,$tabla){
            $sql = "SELECT * FROM $tabla WHERE id=:id";
            return \db\consulta($sql,['id'=>$id]);
        }

        function actualizar($valoresNuevos){
            if(isset($valoresNuevos['idPais'])){
                $sql= "UPDATE pais SET paisnombre=:nombre WHERE id=:id";
                $id=$valoresNuevos['idPais']; 
            } else if(isset($valoresNuevos['idEstado'])){
                $sql= "UPDATE estado SET estadonombre=:nombre WHERE id=:id";
                $id=$valoresNuevos['idEstado'];
            }
            return \db\consulta($sql,['nombre'=>$valoresNuevos['nombre'],'id'=>$id]);
        }

        function borrar($id,$bandera,$string){
            $sql= "DELETE FROM estado WHERE $string=:id";
            $resultado = \db\consulta($sql,['id'=>$id]);
            if($resultado){
                echo "<h1>Se ha podido eliminar los estados</h1>";
                if($bandera){
                    return borrarPais($id);
                }
            } else {
                echo "<h1>No se ha podido eliminar los estados</h1>";                
            }
        }

        function borrarPais($id){     
            $sql= "DELETE FROM pais WHERE id=:id";
            return \db\consulta($sql,['id'=>$id]);
        }

        function nuevo($campo,$id=NULL){
            if($id){
                (!\db\insert($campo,$id)){
                    return FALSE;
                }

                $pdo = \db\conectar();

                return $pdo -> lastInsertId();
            }

            (!\db\insert($campo)){
                return FALSE;
            }

            $pdo = \db\conectar();

            return $pdo -> lastInsertId();

        }


    }
?>