<?php
class Pile
{
    private $_piece;
    private $_nombre;
    
    public function __construct($piece, $nombre) {
        $this->_nombre=$nombre;
        $this->_piece=$piece;
    }
    
    public function getPiece()
    {
        return $this->_piece;
    }
    
    public function getNombre()
    {
        return $this->_nombre;
    }
    //méthode qui calcule les pièces rajoutées ou enlevées de la pile
    public function setNombre($valeur)
    {
        return $this->_nombre+=$valeur; //lorsqu'on diminue la pile on additionne un nbr négatif;
    }
    public function getMontantPile()
    {
        return $montant=$this->_piece->getValeur()*$this->_nombre;
    }
    public function sum ($pile)
    {
        if($this->_piece->equals($pile->getPiece()))
        {
            $this->_nombre+=$pile->getNombre();
        }
        else
        {
            return false;
        }
    }
}
?>
