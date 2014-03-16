<?php

class Distributeur {

    private $_caisse;
    private $_stock;
    private $_canetteCourante;
    // le montant courant est un objet  de type Caisse
    private $_montantCourant;
    // le remboursement est un objet  de type Caisse
    private $_remboursement;
    //faute de mieux, --> voir dans l'action livraison du controlleur le but de cette variable
    public $iteration;
    
    
    public function __construct() {
//instacier la Caisse
        $unEuro = new Piece('unEuro', 1);
        $deuxEuros = new Piece('deuxEuros', 2);
        $cinquanteCents = new Piece('cinquanteCents', 0.50);
        $pile1 = new Pile($unEuro, 10);
        $pile2 = new Pile($deuxEuros, 10);
        $pile3 = new Pile($cinquanteCents, 10);
        $piles = array(
// il est primordial que les key soient exactement les mêmes que celles de la Caisse pour pouvoir appliquer la somme
            "un" => $pile1,
            "deux" => $pile2,
            "cinquante" => $pile3
        );
        $this->_caisse = new Caisse($piles);
//instancier le Stock
        $canetteFanta = new Canette('Fanta');
        $canetteSprite = new Canette('Sprite');
        $canetteCoca = new Canette('Coca-Cola');
        $this->_stock = array(
            $canetteFanta->getMarque() => 5,
            $canetteCoca->getMarque() => 10,
            $canetteSprite->getMarque() => 1);
//instancier montantCourant en tant qu'objet Caisse vide, $remboursement idem et la canetteCourante null
        $this->init();
    }

    public function setCanetteCourante($canette) {
        $this->_canetteCourante = $canette;
    }

    public function getCanetteCourante() {
        return $this->_canetteCourante;
    }

    public function getMontantCourant() {
        return $this->_montantCourant;
    }

    public function setMontantCourant($key, $valeur) {
        $piles = $this->_montantCourant->getPiles();
        $piles[$key] = $valeur;
    }

    public function getCaisse() {
        return $this->_caisse;
    }

    public function setCaisse() {
        $this->_caisse->sum($this->_montantCourant);
    }

    public function getStock() {
        return $this->_stock;
    }

    public function getRemboursement() {

        return $this->_remboursement;
    }

    public function livraison() {

        if ($this->verifierStock() && $this->_montantCourant->getFonds() >= $this->_canetteCourante->getPrix()) {
            $this->diminuerStock($this->_canetteCourante);
            return true;
        } else {
            return false;
        }
    }

    public function verifierStock() {
        if ($this->_stock[$this->_canetteCourante->getMarque()] == null) {
            return false;
        } else {
            return true;
        }
    }

    public function diminuerStock($canette) {
        $marque = $canette->getMarque();
        if ($this->_stock[$marque] > 0) {
            $this->_stock[$marque]-=1;
            if ($this->_stock[$marque] == 0) {
                $this->_stock[$this->_canetteCourante->getMarque()] = null;
            }
        } else {
            return false;
        }
    }

    public function getCalculMonnaie() {
        if ($this->_stock[$this->_canetteCourante->getMarque()] == null&&$this->iteration!=1) {
            return $difference = $this->_montantCourant->getFonds();
        } else {
            return $difference = $this->_montantCourant->getFonds() - $this->_canetteCourante->getPrix();
        }
    }

//calcule le montant à rembourser
//return : Caisse ou false
    public function restituerMonnaie() {
        if ($this->_stock[$this->_canetteCourante->getMarque()] == null&&$this->iteration!=1) {
            $this->_remboursement = $this->_montantCourant;
        } else {
//on vérifie si le prix de la cannette est de 2 euros et ensuite s'il peut être payé par la pile de 2 euros
            $prix = $this->_canetteCourante->getPrix();
            //$remboursement n'est pas une Caisse, est un float!
            $remboursement = $this->_montantCourant->getFonds() - $prix;
            //si des pièces de 2 euros sont de stock, on les met dans une pile qu'on rajoute au montant à rembourser et qu'on enlève de la caisse
            if ($this->_caisse->verifierPileDeuxEuros($remboursement)) {
                $piles=$this->_caisse->verifierPileDeuxEuros($remboursement);
                    $this->calculprogressifMontantArembourser($piles); 
                //s'il y a un restant à payer, les pièces de 2 euros n'ont pas couvert la totalité du remboursement
                if ($remboursement - $this->_remboursement->getFonds() > 0) {
                    //le montant à rembourser a diminué du montant déjà trouvé dans la pile de 2 euros
                    $remboursement = $remboursement - $this->_remboursement->getFonds();
                    //on vérifie si'il reste des pièces de 1 euros
                    if ($this->_caisse->verifierPileUnEuro($remboursement)) {
                        //on reprend la procédure
                        $piles = $this->_caisse->verifierPileUnEuro($remboursement);
                        $this->calculProgressifMontantArembourser($piles);
//s'il y a un restant à payer, les pièces de 1 euro n'ont pas couvert la totalité du remboursement
                        if ($remboursement-$this->_remboursement->getPile(new Piece('unEuro', 1))->getMontantPile() > 0) {
                            $remboursement = $remboursement - $this->_remboursement->getPile(new Piece('unEuro', 1))->getMontantPile();
                            //on fait recours aux pièces de 0,50 euros
                            $piles = $this->_caisse->verifierPileCinquanteCents($remboursement);
                            $this->calculProgressifMontantArembourser($piles);
                        }
                    }
                }
            }
            //pas de pièces de 2 euros, on vérifie s'il y a des pièces de 1 euros en caisse
            elseif ($this->_caisse->verifierPileUnEuro($remboursement)) {
                //on reprend la procédure
                $piles = $this->_caisse->verifierPileUnEuro($remboursement);
                $this->calculProgressifMontantArembourser($piles);
//s'il y a un restant à payer, les pièces de 1 euro n'ont pas couvert la totalité du remboursement
                if ($remboursement-$this->_remboursement->getPile(new Piece('unEuro', 1))->getMontantPile()>0) {
                    $remboursement = $remboursement-$this->_remboursement->getPile(new Piece('unEuro', 1))->getMontantPile();
                    //on fait recours aux pièces de 0,50 euros
                    $piles = $this->_caisse->verifierPileCinquanteCents($remboursement);
                    $this->calculProgressifMontantArembourser($piles);
                }
            } else {
                $piles = $this->_caisse->verifierPileCinquanteCents($remboursement);
                $this->calculProgressifMontantArembourser($piles);
            }
        }
    }

    function calculProgressifMontantArembourser($piles) {
        $montant = new Caisse($piles);
        //on additionne à la caisse $remboursement le montant dispo en Piece respective
        $this->_remboursement->sum($montant);
        //on enlève de la caisse le montant à rembourser jusqu'ici
        $this->_caisse->diff($this->_remboursement);
    }
//fonction appelée à chaque fois que la commande est traitée (dans la view closing.php)
    function init() {
        //le cponstructeur de la Caisse a une surcherge qui instancie la caisse vide s'il n'y a pas de paramètre $piles (de type array)
        $this->_montantCourant = new Caisse();
        $this->_remboursement = new Caisse();
        $this->_canetteCourante = null;
        $this->iteration=0;
    }


}

?>
