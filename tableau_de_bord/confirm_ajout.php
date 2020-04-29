<!DOCTYPE html>
<?php

session_start();
if(isset($_SESSION['email']) == FALSE || isset($_SESSION['mdp']) == FALSE) { // Permet de vérifier que l'utilisateur est connecté
    die('Vous devez être connecté pour accéder à cette page. <a href="../index.php">Retourner à la page d\'accueil</a>');
}

require("../fonction_utile.php");
$cx = connexion();

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Clôture</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
        <?php
            $num_rapport = filter_input(INPUT_GET, 'num_rapport', FILTER_VALIDATE_INT);
            foreach($_POST['ajout'] as $IdIndi) {
                $msg = AjoutIndicPresents($cx, $num_rapport, $IdIndi);
                echo ('<p class="alert alert-success" role="alert" >'.$msg.'</p>');
            }
            echo('<a role="button" class="btn btn-success" href="../rapport.php?num_rapport='.$num_rapport.'">Retour au tableau de bord</a>');
        ?>
        </div>
    </body>
</html>