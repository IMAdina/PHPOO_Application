<div class="col-lg-2 col-sm-2 ecran col-lg-push-1 col-sm-push-1">
    <p>Montant payé: <?= $distributeur->getMontantCourant()->getFonds(); ?></p>
    <p>Le prix à payer est de <?= $distributeur->getCanetteCourante()->getPrix(); ?> euro.</p>
    <p>Quand vous avez fini, apuyez sur le bouton ci-dessous pour recevoir le produit demandé</p>
    <p>L'appareil rend la monnaie.</p>
    <?php if(isset($_GET['reinitialiser'])){?>
    <form method="POST" action="index.php">
        <p>Vous avez payé un montant insufisant.</p>
        <input type="hidden" name="initialiser" />
        <input type="submit" value="Recommencer" class="btn btnCustom"/>
    </form>
    <?}else{?>
    <form method="POST" action="index.php">
        <input type="hidden" name="livraison" />
        <input type="submit" value="Recevoir produit" class="btn btnCustom"/>
    </form>
    <?}?>
</div>