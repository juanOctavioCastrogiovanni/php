<?php 
    namespace validar {
        function validacionProducto($arreglo, &$flag){
            if($arreglo['Marca']=='false'||$arreglo['Categoria']=='false'){
                $flag = FALSE;
                header("location: ./?page=producto&action=". $arreglo['action']. "&rta=0x010");
                echo "<p style='color:red;'>Tiene que seleccionar una marca y una categoria.</p>";
            }


            if( empty($arreglo['Nombre']) || strlen( $arreglo['Nombre'] ) < 5 || is_numeric( $arreglo['Nombre'] ) || is_numeric( substr($arreglo['Nombre'], 0, 1) ) ) {
                $flag = FALSE;
                header("location: ./?page=producto&action=". $arreglo['action']. "&rta=0x011");
                echo "<p style='color:red;'>El nombre tiene caracteres invalidos.</p>";
            }

            if( empty($arreglo['Precio']) ||  !is_numeric( $arreglo['Precio'] )) {
                $flag = FALSE;
                header("location: ./?page=producto&action=". $arreglo['action']. "&rta=0x012");
                echo "<p style='color:red;'>El precio debe ser un numero.</p>";
            }

            
            if( empty(preg_match("/[0-9]{2,3}GB/", $arreglo['Memoria']))) {
                $flag = FALSE;
                header("location: ./?page=producto&action=". $arreglo['action']. "&rta=0x013");
                echo "<p style='color:red;'>El campo memoria debe contener numeros seguidos de la letras GB.</p>";
            }

            if( empty($arreglo['Stock']) ||  !is_numeric( $arreglo['Stock'] )) {
                $flag = FALSE;
                header("location: ./?page=producto&action=". $arreglo['action']. "&rta=0x014");
                echo "<p style='color:red;'>El stock debe estar escrito en numeros.</p>";
            }
        }
    }
?>