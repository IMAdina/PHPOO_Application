
<div class="col-lg-2 col-sm-2 ecran col-lg-push-1 col-sm-push-1">
    <p>Vous avez demandé une canette de <?= $distributeur->getCanetteCourante()->getMarque();?></p>
    <p>Le prix à payer est de <?= $distributeur->getCanetteCourante()->getPrix();?> euro.</p>
    <p>Insérez les pièces en appuyant sur chaque image.</p>
    <p>L'appareil rend la monnaie.</p>
</div>
