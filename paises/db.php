<?php
    namespace db{
        function conectar($datos=NULL, $userName='root', $password=''){
            static $pdo = NULL;
            if ($pdo){
                return $pdo;
            }

            $pdo= new \PDO($datos,$userName,$password);
            return $pdo;
        }

        function consulta($sql,$values=array()){
            $pdo = conectar();

            $stmt = $pdo->prepare($sql);

            // echo "<h1>".$sql."</h1>";
            // if($values){
            // echo "<h1>".$values['nombre']."</h1>";
            // echo "<h1>".$values['id']."</h1>";
            // }
            // die();

            foreach($values as $campo => $valor){
                $stmt -> bindValue(":$campo",$valor);
            }

            if(!$stmt->execute()){
                return FALSE;
            }

                return $stmt;
        }

        function insert($campo,$id=NULL){
            if($id){
                $sql=
            }

            $nombre= "" ;
            $sql = "INSERT INTO pais SET paisnombre=:nombre";



        }
    }


?>