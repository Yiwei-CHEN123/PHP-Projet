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
        <title>Ajout indicateur</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
        <?php
            $num_rapport = filter_input(INPUT_GET, 'num_rapport', FILTER_VALIDATE_INT);
            echo('<form method="POST" action="confirm_ajout_new.php?num_rapport='.$num_rapport.'">');
        ?>
        <p><textarea name="desc_indi" rows=3 cols=50 wrap=virtual required>Rédigez ici la description de l'indicateur à ajouter à la base</textarea></p>
        <p><textarea name="analy_indi" rows=5 cols=50 wrap=virtual>Rédigez ici l'analyse de l'indicateur (facultatif)</textarea></p>
        <p><textarea name="rq_indi" rows=3 cols=50 wrap=virtual>Mentionner ici la requête (SQL) permettant d'alimenter l'indicateur (facultatif)</textarea></p>            
        <p><input type="submit"></p>
            </form>
        </div>
    </body>
</html>
