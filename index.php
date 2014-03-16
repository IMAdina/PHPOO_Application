<?
require_once 'Piece.class.php';
require_once 'Pile.class.php';
require_once 'Canette.class.php';
require_once 'Caisse.class.php';
require_once 'Distributeur.class.php';
session_start();
//si première visite on instancie un distributeur, sinon, on le récupère de la session
if (isset($_SESSION['distributeur']) && !empty($_SESSION['distributeur'])) {
    $distributeur = $_SESSION['distributeur'];
} else {
    $distributeur = new Distributeur();
}
require_once 'distributeurController.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link href="css/custom.css" rel="stylesheet"/>
        <script src="js/respond.js"></script>
        <title>Distributeur canettes</title>
    </head>

    <body>
        <div class="container">
            <!-- row 1 -->
            <header class="row">
                <div class="col-lg-3 col-sm-5">
                    <a href='index.php#'> <img src="img/logo.png" class="logo"/></a>

                </div>
                <div class="col-lg-9 col-sm-7">
                    <h1>Distributeur de canettes</h1>
                </div>
            </header>

            <!-- row 2 -->
            <div class="row">
                <?
                if (!isset($_GET['ecran'])) {
                    require_once 'ecranAccueil.php';
                } else if (isset($_GET['ecran']) && in_array($_GET['ecran'], array('montant', 'paiement', 'livraison', 'finish', 'noStock', 'closing'))) {
                    $ecran = $_GET['ecran'];
                    require_once $ecran . '.php';
                } else {
                    require_once '404.php';
                }
                ?>
                <div class="col-lg-3 col-sm-3 col-lg-push-2 col-sm-push-2">
                    <form method="POST" action="index.php">
                        <p><input class="custom btn" type="image" src="img/unEuro.jpg" alt="Submit"><img src="img/fente.png" alt="fente"/></p>
                        <input type="hidden" name="unEuro" />
                    </form>
                    <form method="POST" action="index.php">
                        <p><input class="custom btn" type="image" src="img/deuxEuros.jpg" alt="Submit"></p>
                        <input type="hidden" name="deuxEuros" />
                    </form>
                    <form method="POST" action="index.php">
                        <p><input class="custom btn" type="image" src="img/cinquanteCents.jpg" alt="Submit"></p>
                        <input type="hidden" name="cinquanteCents" />
                    </form>
                </div><!--fin de l'afficahge des monnaies-boutons-->
                <div class="col-lg-4 col-sm-4">
                    <img src="img/distributeur.png" />
                    <a href='index.php?ecran=montant&produit=Coca-Cola' class="cola produit1"></a>
                    <a href='index.php?ecran=montant&produit=Coca-Cola' class="cola produit2"></a>
                    <a href='index.php?ecran=montant&produit=Fanta' class="fanta produit3"></a>
                    <a href='index.php?ecran=montant&produit=Fanta' class="fanta produit4"></a>
                    <a href='index.php?ecran=montant&produit=Sprite' class="sprite produit5"></a>
                    <a href='index.php?ecran=montant&produit=Sprite' class="sprite produit6"></a>
                </div> 
            </div> 
            <div class="row">
            </div>

            <footer class="row">

                <p>Distributeur Canettes PHP POO @ déc.2013</p>
            </footer>
        </div>
        <!-- javascript -->
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>