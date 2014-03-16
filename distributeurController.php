<?php

session_start();
//traitement de l'action "constitutionCanetteCourante"(terme générique)
//@param: Canette $canette
//GET
if (isset($_GET['produit']) && !empty($_GET['produit'])) {
    $marque = $_GET['produit'];
    $canette = new Canette($marque);
    $distributeur->setCanetteCourante($canette);
    $_SESSION['distributeur'] = $distributeur;
}
//traitement de l'action "payer"(terme générique)
//instancier le montantCourant et le sauvegarder dans le $distributeur
//@var: $montantCourant: Caisse
//@param: $unEuro, $deuxEuros ou $cinquanteCents : Piece
//POST
if (isset($_POST['unEuro'])) {
    $unEuro = new Piece('unEuro', 1);
    $pile1 = $distributeur->getMontantCourant()->getPile($unEuro);
    $pile1->setNombre(1);
    $distributeur->setMontantCourant('un', $pile1);
    $_SESSION['distributeur'] = $distributeur;
    $_GET['ecran'] = 'paiement';
}
if (isset($_POST['deuxEuros'])) {
    $deuxEuros = new Piece('deuxEuros', 2);
    $pile2 = $distributeur->getMontantCourant()->getPile($deuxEuros);
    $pile2->setNombre(1);
    $distributeur->setMontantCourant('deux', $pile2);
    $_SESSION['distributeur'] = $distributeur;
    $_GET['ecran'] = 'paiement';
}
if (isset($_POST['cinquanteCents'])) {
    $cinquanteCents = new Piece('cinquanteCents', 0.50);
    $pile3 = $distributeur->getMontantCourant()->getPile($cinquanteCents);
    $pile3->setNombre(1);
    $distributeur->setMontantCourant('cinquante', $pile3);
    $_SESSION['distributeur'] = $distributeur;
    $_GET['ecran'] = 'paiement';
}

//traitement de l'action "livraison"
//POST
if (isset($_POST['livraison'])) {

    if ($distributeur->verifierStock()) {
        //on vérifier que le montant payé est >= que le prix
        if ($distributeur->livraison()) {
            //pour éviter de calculer la monnaie en sachant que le dernier produit est en train d'être livré et alors $distributeur->Stock[marque]==null déjà!
            $distributeur->iteration=1;
            $_GET['ecran'] = 'livraison';
        } else {
            $_GET['reinitialiser']=true;
            $_GET['ecran'] = 'paiement';
        }
    } else {
        $_GET['stockEpuise'] = true;
        $_GET['ecran']='livraison';
    }
}
//traitement de l'action "rembourser"
////@param : int (montant à rembourser)
//POST
if (isset($_POST["rembourser"])) {
    
    //on additionne le montant courant à la caisse
    $distributeur->setCaisse();
    if ($_POST["rembourser"] != "") {
        
        $distributeur->getRemboursement();
    }
    
    $_GET['ecran']='closing';
}

//traitement de l'action "nouvelle commande"
//
//POST
if (isset($_POST["initialiser"])) {

    if (isset($_POST["initialiser"])) {
        $distributeur->init();
    }
}

?>
