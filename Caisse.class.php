<?php

class Caisse {

    private $_piles;

    //simuler 2 surcharges en PHP 
    public function __construct() {
        //$parameters: array(@param1, @param2, etc.);
        $unEuro = new Piece('unEuro', 1);
        $deuxEuros = new Piece('deuxEuros', 2);
        $cinquanteCents = new Piece('cinquanteCents', 0.50);
        $parameters = func_get_args();
        switch (func_num_args()) {
            case 0:
                $pile1 = new Pile($unEuro, 0);
                $pile2 = new Pile($deuxEuros, 0);
                $pile3 = new Pile($cinquanteCents, 0);
                $piles = array(
                    "un" => $pile1,
                    "deux" => $pile2,
                    "cinquante" => $pile3
                );
                $this->_piles = $piles;
                break;
            case 1:
                $this->_piles = $parameters[0];
                break;
        }
    }

    public function getPiles() {
        return $this->_piles;
    }

    public function getFonds() {
        $fonds = 0;
        foreach ($this->_piles as $pile) {
            if ($pile != null) {
                $fonds+=$pile->getMontantPile();
            }
        }
        return $fonds;
    }

    public function getPile($piece) {
        foreach ($this->_piles as $pile) {
            if ($pile->getPiece()->equals($piece)) {
                return $pile;
            } else {
                continue;
            }
        }
    }

    //@param $montant : Caisse
    public function sum($montant) {
        //foreach similar key sum piles

        foreach ($this->_piles as $pile) {
            foreach ($montant->getPiles() as $pile1)
                if ($pile->getPiece()->equals($pile1->getPiece())) {
                    for ($i = 0; $i < $pile1->getNombre(); $i++) {
                        $pile->setNombre(1);
                    }
                }
        }
    }

    //méthode aidant à déterminer la restitution de la monnaie dans le distributeur
    //calcule le nbr de pièces de 2 euros comprises dans le prix de la canetteCourante
    //renvoie la pile de 2 euro remplie des pièces disponibles dans la caisse qui peut satisfaire le prix demandé ou pas
    //return $piles : array<Pile>;
    public function verifierPileDeuxEuros($remboursement) {
        $unEuro = new Piece('unEuro', 1);
        $deuxEuros = new Piece('deuxEuros', 2);
        $cinquanteCents = new Piece('cinquanteCents', 0.50);
        $pile1 = new Pile($unEuro, 0);
        $pile3 = new Pile($cinquanteCents, 0);
        if ($this->getPile($deuxEuros)->getNombre() > 0) {
            //le remboursement est un integer ou un float et il y a suffisament de pièces pour le calculer
            if ($this->getPile($deuxEuros)->getMontantPile() >= $remboursement) {
                $nbrPieces = floor($remboursement / 2);
                $pile2 = new Pile($deuxEuros, $nbrPieces);
            } else {//pas suffisament de pièces de 2 euros pour rembourser le montant juste
                //on donne toute la pile de 2euros de la caisse
                $pile2 = $this->getPile($deuxEuros);
            }
            $piles = array(
                "un" => $pile1,
                "deux" => $pile2,
                "cinquante" => $pile3
            );
            return $piles;
        } else {
            return false;
        }
    }

    //méthode aidant à déterminer la restitution de la monnaie dans le distributeur
    //calcule le nbr de pièces de 1 euros comprises dans le prix de la canetteCourante
    //renvoie la pile de 1 euro remplie des pièces disponibles dans la caisse qui peut satisfaire le prix demandé ou pas
    //return $piles : array<Pile>;
    public function verifierPileUnEuro($remboursement) {
        $unEuro = new Piece('unEuro', 1);
        $deuxEuros = new Piece('deuxEuros', 2);
        $cinquanteCents = new Piece('cinquanteCents', 0.50);
        $pile2 = new Pile($deuxEuros, 0);
        $pile3 = new Pile($cinquanteCents, 0);
        if ($this->getPile($unEuro)->getNombre() > 0) {
            //le remboursement est un integer ou un float et il y a suffisament de pièces pour le calculer
            if ($this->getPile($unEuro)->getMontantPile() >= $remboursement) {
                $pile1 = new Pile($unEuro, floor($remboursement));
            } else {//pas suffisament de pièces de 1 euros pour rembourser le montant juste
                //on donne toute la pile de 1euro
                $pile1 = $this->getPile($unEuro);
            }
            $piles = array(
                "un" => $pile1,
                "deux" => $pile2,
                "cinquante" => $pile3
            );
            return $piles;
        } else {
            return false;
        }
    }

    //méthode aidant à déterminer la restitution de la monnaie dans le distributeur
    //calcule le nbr de pièces de 0,5 euros comprises dans le prix de la canetteCourante
    //renvoie la pile de 1 euro remplie des pièces disponibles dans la caisse qui peut satisfaire le prix demandé ou pas
    //return $piles : array<Pile>;
    public function verifierPileCinquanteCents($remboursement) {
        $unEuro = new Piece('unEuro', 1);
        $deuxEuros = new Piece('deuxEuros', 2);
        $cinquanteCents = new Piece('cinquanteCents', 0.50);
        $pile2 = new Pile($deuxEuros, 0);
        $pile1 = new Pile($unEuro, 0);
        if ($this->getPile($cinquanteCents)->getNombre() > 0) {
            //le remboursement est un integer ou un float et il y a suffisament de pièces pour le calculer
            if ($this->getPile($cinquanteCents)->getMontantPile() >= $remboursement) {
                $pile3 = new Pile($cinquanteCents, intval($remboursement / 0.50));
            }
            $piles = array(
                "un" => $pile1,
                "deux" => $pile2,
                "cinquante" => $pile3
            );
            return $piles;
        } else {
            return false;
        }
    }

    //diminuer la caisse du nombre de pièces contenu dans les $piles
    //@param : Caisse
    public function diff($montant) {

        foreach ($this->_piles as $pile) {

            foreach ($montant->getPiles() as $pileRecue)
                if ($pile->getPiece()->equals($pileRecue->getPiece())) {

                    for ($i = 0; $i < $pileRecue->getNombre(); $i++) {

                        $pile->setNombre(-1);
                    }
                }
        }
    }

}

?>
