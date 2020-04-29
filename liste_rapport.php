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
        <title>Consulter les rapports</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h1>Liste des rapports</h1>
        <ul>
            <p>Cliquez sur l'année dont vous voulez voir les rapports</p>
            <li><a href="liste_rapport.php?annee_rapport=2018">2018</a></li>
            <li><a href="liste_rapport.php?annee_rapport=2019">2019</a></li>
            <li><a href="liste_rapport.php?annee_rapport=2020">2020</a></li>
        </ul>
        <ul>
        <?php
            $annee = filter_input(INPUT_GET, 'annee_rapport', FILTER_VALIDATE_INT);
            $rapport = ListeRapportAnnee($cx,$annee);
            echo('<h1> Liste des rapports de l\'année sélectionnée</h1>');
            if ($rapport == NULL) {
                die('<p class="alert alert-danger" role="alert">Il n\'y a pas rapports correspondant à cette année</p>');
            } else {
                foreach($rapport as $nupletRapport){
                    echo('<li>');
                    echo('<a href="liste_rapport.php?num_rapport='.$nupletRapport['NumeroR'].'"> '.$nupletRapport['NumeroR'].' - '.$nupletRapport['TitreR'].'</a>');
                    echo('</li>');
                }
            }
        ?>
        </ul>
            <?php
            $num_rapport = filter_input(INPUT_GET, 'num_rapport', FILTER_VALIDATE_INT);
            $indicateur = ListeIndicateursRapport($cx, $num_rapport);
            if ($indicateur == NULL) {
                echo('<p class="alert alert-primary" role="alert" >Vous n\'avez pas encore sélectionné de rapports</p>');
            } else {
                foreach($indicateur as $nupletIndicateur){
                    echo('
                    <p>
                        <table border="1px" class="table">
                            <tr>
                                <th>Description</th>
                                <th>Analyse</th>
                            </tr>
                            <tr>
                                <td>'.$nupletIndicateur['NomIndi'].'</td>
                                <td>'.$nupletIndicateur['AnalyseIndi'].'</td>
                            </tr>
                        </table>
                    </p>');
                }
            echo('<p><a role="button" class="btn btn-primary" href="rapport.php?num_rapport='.$num_rapport.'">Accéder au tableau de bord concernant le rapport n°'.$num_rapport.'</a></button></p>');
            }
            ?>
        </div>
    </body>
</html>
