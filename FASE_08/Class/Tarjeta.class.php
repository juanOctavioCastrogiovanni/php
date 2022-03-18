<?php
    class Tarjeta{
        public function __construct($array, $bool){
            foreach ($array as $index => $productoParticular) {
				try{
					if (($index+1)%3==0){
						$productoParticular->mostrarTarjeta($bool,1);
					} else {
						$productoParticular->mostrarTarjeta($bool,0);
					}
				} catch(Exception $e){
					echo "<p>{$e->getMessage()}</p>";
				}
			}
        }
    }
?>