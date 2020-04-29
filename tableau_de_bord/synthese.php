<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();
if(isset($_SESSION['email']) == FALSE || isset($_SESSION['mdp']) == FALSE) { // Permet de vérifier que l'utilisateur est connecté
    die('Vous devez être connecté pour accéder à cette page. <a href="../index.php">Retourner à la page d\'accueil</a>');
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Synthèse</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
        <?php
            $num_rapport = filter_input(INPUT_GET, 'num_rapport', FILTER_VALIDATE_INT);
        echo('<form method="POST" action="confirm_synthese.php?num_rapport='.$num_rapport.'">');
        ?>
            <textarea name="synthese" rows=5 cols=50 wrap=virtual>Rédiger ici votre synthèse</textarea>
            <input class="btn btn-primary" type="submit">
        </form>
        </div>
    </body>
</html>
