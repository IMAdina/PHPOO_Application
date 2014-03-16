<?php

class Canette {

    private $_marque;
    private $_prix;

    public function __construct($marque) {
        $this->_marque=$marque;
        if($this->_marque=='Fanta')
        {
            $this->_prix=1;
        }
        else if($this->_marque=='Sprite')
        {
            $this->_prix=1.50;
        }
        else if($this->_marque=='Coca-Cola')
        {
            $this->_prix=2;
        }
    }

    public function getMarque() {
        return $this->_marque;
    }

    public function getPrix() {
        return $this->_prix;
    }

    
}

?>
