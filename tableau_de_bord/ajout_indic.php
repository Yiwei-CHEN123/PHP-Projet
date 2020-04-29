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

require("../fonction_utile.php");
$cx = connexion();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Choix indicateur</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
        <?php
        $num_rapport = filter_input(INPUT_GET, 'num_rapport', FILTER_VALIDATE_INT);
        $indicateurs = ListeIndicateursRapportNonPresent($cx, $num_rapport);
        if ($indicateurs == NULL) {
            echo('<p class="alert alert-danger" role="alert" >Il n\'existe pas d\'indicateurs n\'ayant pas déjà été ajouté à ce rapport </p>');
            echo('<p><a role="button" class="btn btn-primary" href="rapport.php?num_rapport='.$num_rapport.'">Retour au tableau de bord</a></p>');
        } else {
            echo('<form method="POST" action="confirm_ajout.php?num_rapport='.$num_rapport.'">');
            echo('<p>Choisir les indicateurs que vous souhaitez ajouter au rapport</p>');
            foreach($indicateurs as $nupletIndicateurs) {
                echo('<p>');
                echo('<input type="checkbox" id="'.$nupletIndicateurs['IDIndi'].'"  name="ajout[]" value="'.$nupletIndicateurs['IDIndi'].'">');
                echo('<label for="'.$nupletIndicateurs['IDIndi'].'">'.$nupletIndicateurs['NomIndi'].'</label>');
                echo('</p>');
            }
            echo('<input type=submit>');
            echo('</form>');
        }
        ?>
        </div>
    </body>
</html>
