<h1>Por favor escriba un nuevo pais</h1>

<?php
echo $error; 
?>
  <form method="POST" action="">
            <input type="text" name="pais">
            <input type="hidden" name="p" value="nuevo">
        <button type="submit">Crear</button>
   </form>