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

        public function mostrarTarjeta($bool, $ultimo){
            if(!$this->nombre){
                throw new Exception("No se ha definido el nombre de este producto");
            }
            if(!$this->precio){
                throw new Exception("No se ha definido el nombre de este producto");
            }
            if(!$this->imagen){
                throw new Exception("No se ha definido el nombre de este producto");
            }

            echo "<div class='col-sm-4 col-md-4 chain-grid "; 
                    
                if($ultimo){echo "grid-top-chain'>";} else {echo "'>";}

                  echo "<a href='?page=producto'><img class='img-responsive chain' src='./images/productos/".$this->imagen."' alt=' ' /></a>";
                  if($bool){
                    echo "<span class='star'></span>";
                  }
                   echo "<div class='grid-chain-bottom'>
                        <h6><a href='?page=producto'>".$this->nombre."</a></h6>
                        <div class='star-price'>
                            <div class='dolor-grid'> 
                                <span class='actual'>".$this->precio."</span>
                            </div>
                            <a class='now-get get-cart' href='?page=producto'>VER MÁS</a> 
                            <div class='clearfix'></div>
                        </div>
                    </div>
                </div>";
                
                if($ultimo){echo "<div class='col-sm-12 col-md-12' style='height:40px'></div>";} else {echo "";}
        }
    }
?>