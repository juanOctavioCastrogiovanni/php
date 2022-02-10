
<?php if($action!='delete'){ ?>
<h2 style="margin-top:50px;">Formulario de <?php if($update) {echo "edición";} else {echo "creación";}?></h2>
<form method="POST" action="./admin/respuesta.php">
    <input type="hidden" name="action" value="<?php echo $action ?>">
    <?php

    if($action=='update'){
        echo "<input type='hidden' name='idProducto' value='".$producto['idProducto']."'>";
    }

     ?>
    <table>
        <tr>
            <td><label>Nombre:</label></td>
            <td><input type="text" name="Nombre" <?php if($action=='update') {echo "value='".$producto['Nombre']."'";}?>></td>
        </tr>
        <tr>
            <td><label>Precio:</label></td>
            <td><input type="text" name="Precio" <?php if($action=='update') {echo "value='".$producto['Precio']."'";}?>></td>
        </tr>
        <tr>
        <td><label>Marca:</label></td>
            <td>
                <select style="width: 100%;" name="Marca">
                    <?php 
                    $flag = FALSE;
                    foreach ($marcas as $marca){  
                        if($producto['idMarca']==$marca['idMarca']){
                            $flag = TRUE;
                            echo "<option value='".$marca['idMarca']."' selected>".$marca['Nombre']."</option>";
                        } else {
                            echo "<option value='".$marca['idMarca']."'>".$marca['Nombre']."</option>";
                        }
                    }
                        if($flag == FALSE){
                            echo "<option value='false' selected> Seleccione una marca... </option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>

        </tr>
        <tr>
            <td><label>Categoria:</label></td>
            <td>
                <select style="width: 100%;" name="Categoria">
                    <?php 
                    $flag = FALSE;
                    foreach ($categorias as $categoria){  
                        if($producto['idCategoria']==$categoria['idCategoria']){
                            $flag = TRUE;
                            echo "<option value='".$categoria['idCategoria']."' selected>".$categoria['Nombre']."</option>";
                        } else {
                            echo "<option value='".$categoria['idCategoria']."'>".$categoria['Nombre']."</option>";
                        }
                    }
                        if($flag == FALSE){
                            echo "<option value='false' selected> Seleccione una marca... </option>";
                        }
                    ?>
                </select>
            </td>
        </tr> 
        <tr>
            <td><label>Memoria:</label></td>
            <td><input type="text" name="Memoria" <?php if($action=='update') {echo "value='".$producto['Memoria']."'";}?>></td>
        </tr>
        <tr>
            <td><label>Stock:</label></td>
            <td><input type="text" name="Stock" <?php if($action=='update') {echo "value='".$producto['Stock']."'";}?>></td>
        </tr>
    </table>
    <button type="submit"><?php if($update) {echo "Modificar";} else {echo "Crear";}?></button>
</form>
<?php } 
// else { echo $eliminado;}
?>

