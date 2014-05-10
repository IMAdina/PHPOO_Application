
<div class="col-lg-2 col-sm-2 ecran col-lg-push-1 col-sm-push-1">
    <?$distributeur->restituerMonnaie();
    if($distributeur->getRemboursement()->getFonds()!=0){?>
    <p>Vous recevez la monnaie distribuée en:</p>
    <p><?

            
            if ($distributeur->getRemboursement()->getPile(new Piece("deuxEuros", 2))->getNombre() != 0) {
                echo '' . $distributeur->getRemboursement()->getPile(new Piece("deuxEuro", 2))->getNombre();
            } else {
                echo '0';
            }
            ?>
            pièces de 2 euros</p>
        <p><?
            if ($distributeur->getRemboursement()->getPile(new Piece("unEuro", 1))->getNombre() != 0) {
                echo '' . $distributeur->getRemboursement()->getPile(new Piece("unEuro", 1))->getNombre();
            } else {
                echo '0';
            }
            ?>
            pièces de 1 euros</p>
        <p><?
            if ($distributeur->getRemboursement()->getPile(new Piece("cinquanteCents", 0.5))->getNombre() != 0) {
                echo '' . $distributeur->getRemboursement()->getPile(new Piece("cinquanteCents", 0.5))->getNombre();
            } else {
                echo '0';
            }
        ?>
            pièces de 0,5 euros</p><?}else{?>
            <p>Pas de monnaie à rembourser.</p><?}?>
    <form method="POST" action="index.php">
        <input type="hidden" name="initialiser" /><!--je dois renvoyer comme paramètre le total de la monnaie à rembourser-->
        <input type="submit" value="Nouvelle commande" class="btn btnCustom"/>
    </form>


</div>
