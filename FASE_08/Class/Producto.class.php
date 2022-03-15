<?php
    class Producto{
        public $idProducto = NULL;
        public $nombre = NULL;
        public $precio = NULL;
        public $marca = NULL;
        public $imagen = NULL;

        public function __construct($idProducto = NULL,$nombre = NULL,$precio = NULL,$marca = NULL,$imagen = NULL){
            $this->idProducto = $idProducto;
            $this->nombre = $nombre;
            $this->precio = $precio;
            $this->marca = $marca;
            $this->imagen = $imagen;
        }
    }
?>