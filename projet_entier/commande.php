<?php
// charger le fichier des fonctions
require("fonction_utile.php");

// executer la fonction de connexion
$cx = connexion();
session_start();

?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <title>La fonction principale</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style1.css">
</head>

<body id="body0">

    <a href="fonct_principe.php">Retour</a>
    <p> Sélectionnez un secteur de service : </p>

    <form action="commande_result.php" method="POST">
        <?php 
            // Faire la distinction pour les différents utilisateurs
            if ($_SESSION['Poste'] == "Directeur" or $_SESSION['Poste'] == "Directeur Adjoint") {
                $requete = "SELECT IDPoste, NomPoste FROM Postes WHERE NomPoste = 'Directeur des ventes' or NomPoste = 'Service Marketing' or NomPoste = 'Service Financier' ;";
            } else {
                $requete = "SELECT IDPoste, NomPoste FROM Postes WHERE NomPoste = 'Service Marketing' or NomPoste = 'Service Financier' ;";
            } 
            $curseur = mysqli_query($cx, $requete);

            if ($curseur == FALSE) {
                // si la connexion est en échec 
                die("Erreur sélection service : ".mysqli_error($cx));
            } else {
                echo '<select name = "select">';
                echo '<option disabled selected value="0">default</option>';
                // parcour du curseur 
                while ($nuplet = mysqli_fetch_array($curseur)) {
                    $id = $nuplet["IDPoste"];
                    echo '<option name = "opt_serv" value= "'.$nuplet["IDPoste"].'">';
                    echo $nuplet["NomPoste"];
                    echo '</option>';
                }
                echo("</select>");    
            }
        ?>

        <p>Sélectionnez les indicateurs à analyser :</p>


        <?php
        // Chercher les indicateurs dans la base de données
        $requete = "SELECT IDIndi, NOMIndi FROM Indicateurs ORDER BY 1";
        $curseur = mysqli_query($cx, $requete);

        if ($curseur == FALSE) {
            // si la connexion est en échec 
            die("Erreur sélection indicateur : ".mysqli_error($cx));
        }

        // parcour du curseur 
        while ($nuplet = mysqli_fetch_array($curseur)) {
            
            $idIndi = $nuplet["IDIndi"];
            echo ("<p>");          
            echo '<input type = "checkbox" name = "opt_indi[]" value = "'.$nuplet["IDIndi"].'"/>';
            echo $nuplet["NOMIndi"];
            echo ("</br>");
            echo '</p>';
        }
        echo("</select>");       
        
        ?>

        <p>Entrez le titre de rapport :</p>
        
        <input type="text" name="titreR" id="text1" value="" />
        <input type="submit" name="faire_cmd" id="btn1" value="Faire la commande" />
        
    </form>

    <script type="text/javascript">
        var btnclick = document.getElementById("btn1");
        
        btnclick.onclick = function () {
            window.location.href = "commande_result.php";            
        }
    </script>
</body>


</html>