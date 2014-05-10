<div class="col-lg-2 col-sm-2 ecran col-lg-push-1 col-sm-push-1">
    <?
    if (!isset($_GET['stockEpuise'])) {
        echo '<p>Vous recevez le produit: une canette de '. $distributeur->getCanetteCourante()->getMarque().'.</p>';
    } else {
        echo "<p>Ce produit n'est plus de stock.<p>";
    }
    ?>
    <p>Pour récupérer la monnaie: <?= $distributeur->getCalculMonnaie(); ?> euro
        appuyez sur le bouton ci-dessous</p>
    <form method="POST" action="index.php">
        <input type="hidden" name="rembourser" value="<?= $distributeur->getCalculMonnaie(); ?>"/><!--je dois renvoyer comme paramètre le total de la monnaie à rembourser-->
        <input type="submit" value="Recevoir monnaie" class="btn btnCustom"/>
    </form>
</div>