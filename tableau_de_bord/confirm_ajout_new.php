<!DOCTYPE html>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

if(isset($_SESSION['email']) == FALSE || isset($_SESSION['mdp']) == FALSE) { // Permet de vérifier que l'utilisateur est connecté
    die('Vous devez être connecté pour accéder à cette page. <a href="../index.php">Retourner à la page d\'accueil</a>');
}

require("../fonction_utile.php");
$cx = connexion();


$num_rapport = filter_input(INPUT_GET, 'num_rapport', FILTER_VALIDATE_INT);
$desc_indi = $_POST[('desc_indi')];
$analy_indi = $_POST[('analy_indi')];
$rq_indi = $_POST[('rq_indi')];
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
            $result = AjoutNewIndic($cx, $desc_indi, $analy_indi, $rq_indi);
            echo ('<p class="alert alert-success" role="alert" >'.$result.' </p>');
            echo('<p><a role="button" class="btn btn-success" href="../rapport.php?num_rapport='.$num_rapport.'">Retour au tableau de bord</a></p>');
        ?>
        </div>
    </body>
</html>