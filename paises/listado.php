<ul>
        <?php foreach($paises as $pais){?>
            <li><a href="?p=detalle&id=<?php echo $pais['id'];?>"><?php echo $pais['Pais'];?></li>
        <?php }
        
?>