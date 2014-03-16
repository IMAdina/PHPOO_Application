<?php

Class Piece {

    private $_type;
    private $_valeur;

    public function __construct($type, $valeur) {
        $this->_type = $type;
        $this->_valeur = $valeur;
    }

    public function getType() {
        return $this->_type;
    }

    public function getValeur() {
        return $this->_valeur;
    }

    public function equals($piece) {
        if ($this->_valeur === $piece->getValeur()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function addition($piece)
    {
        return $this->_valeur+=$piece->valeur;
    }
}

?>
