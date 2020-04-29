<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();

if(isset($_SESSION['email']) == FALSE || isset($_SESSION['mdp']) == FALSE) { // Permet de vérifier que l'utilisateur est connecté
    die('Vous devez être connecté pour accéder à cette page. <a href="index.php">Retourner à la page d\'accueil</a>');
}

require("fonction_utile.php");
$cx = connexion();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tableau de Bord</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
        <?php
        $num_rapport = filter_input(INPUT_GET, 'num_rapport', FILTER_VALIDATE_INT);
        $_SESSION['NumeroR'] = $num_rapport;
        if (isset($_SESSION['IDPoste']) == FALSE){
            die('<p>Vous ne pouvez pas accéder à cette page</p>');
        } elseif($_SESSION['IDPoste'] == '1') {
            echo('<p><h2>Rapport n°'.$num_rapport.'</h2></p>');
            echo('<p><a role="button" class="btn btn-primary" href="tableau_de_bord/renvoyer.php?num_rapport='.$num_rapport.'">Renvoyer à l\'étude</a></p>');
            echo('<p><a role="button" class="btn btn-primary" href="tableau_de_bord/cloturer.php?num_rapport='.$num_rapport.'">Clôture du rapport</a></p>');
            echo('<p><a role="button" class="btn btn-primary" href="commentaire.php?=num_rapport='.$num_rapport.'">Accédder aux Commentaires</a></p>');
        } elseif($_SESSION['IDPoste'] == '2') {
            echo('<p><h2>Rapport n°'.$num_rapport.'</h2></p>');
            echo('<p><a role="button" class="btn btn-primary" href="tableau_de_bord/synthese.php?num_rapport='.$num_rapport.'">Rédiger la synthèse du rapport</a></p>');
            echo('<p><a role="button" class="btn btn-primary" href="tableau_de_bord/renvoyer.php?num_rapport='.$num_rapport.'">Renvoyer à l\'étude</a></p>');
            echo('<p><a role="button" class="btn btn-primary" href="tableau_de_bord/envoyer_dir.php?num_rapport='.$num_rapport.'">Envoyer au directeur</a></p>');
            echo('<p><a role="button" class="btn btn-primary" href="commentaire.php?=num_rapport='.$num_rapport.'">Accédder aux Commentaires</a></p>');
        } elseif($_SESSION['IDPoste'] == '6' || $_SESSION('IDPoste') == '7'){
            echo('<p><h2>Rapport n°'.$num_rapport.'</h2>');
            echo('<p><a role="button" class="btn btn-primary" href="tableau_de_bord/ajout_indic.php?num_rapport='.$num_rapport.'">Ajouter un indicateur déjà connu au rapport</a></p>');
            echo('<p><a role="button" class="btn btn-primary" href="tableau_de_bord/ajout_new_indic.php?num_rapport='.$num_rapport.'">Ajouter un nouvel indicateur (SQL)</a></p>');
            echo('<p><a role="button" class="btn btn-primary" href="commentaire.php?=num_rapport='.$num_rapport.'">Accédder aux Commentaires</a></p>');
        }
        ?>
        </div>
    </body>
</html>
