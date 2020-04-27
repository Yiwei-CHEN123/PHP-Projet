<?php
// charger le fichier des fonctions
require("Fonction_utile.php");

// executer la fonction de connexion
$cx = connexion();

?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <title>La fonction principale</title>
</head>

<body>

    <a href="Fonct_Principe.html">Retour</a>
    <p> Sélectionner un secteur de service : </p>

    <form action="Commande_result.php" method="GET">
        <?php 
        $requete = "SELECT IDPoste, NomPoste FROM Postes ORDER BY 1";
        $curseur = mysqli_query($cx, $requete);

        if ($curseur == FALSE) {
            // si la connexion est en échec 
            die("Erreur sélection service : ".mysqli_error($cx));
        } else {
            echo("<select>");
            while ($nuplet = mysqli_fetch_array($curseur)) {
                echo("<option name = 'opt_serv'"
                ."value= '".$nuplet["IDPoste"]."' >");
                echo($nuplet["NomPoste"]);
                echo("</option>");
            }
            echo("</select>");
        }
        ?>

        <p>Sélectionner les indicateurs à analyser :</p>
        
        <?php
        $requete = "SELECT IDIndi, NOMIndi FROM Indicateurs ORDER BY 1";
        $curseur = mysqli_query($cx, $requete);

        if ($curseur == FALSE) {
            // si la connexion est en échec 
            die("Erreur sélection indicateur : ".mysqli_error($cx));
        }
        echo("<select>");
        // parcour du curseur 
        while ($nuplet = mysqli_fetch_array($curseur)) {
            
            echo("<option name = 'opt_indi'"
            ."value= '".$nuplet["IDIndi"]."' >");
            //echo("<input type = 'radio' name = 'rd_indi'"
            //."value= '".$nuplet["IDIndi"]."' />");
            echo($nuplet["NOMIndi"]);
            echo("</option>");

        }
        echo("</select>");
        ?>

        <input type="submit" name="faire_cmd" id="btn1" value="Faire la commande" />
        
    </form>
    <script type="text/javascript">
        var btnclick = document.getElementById("btn1");
        
        btnclick.onclick = function () {
            var myDate = new Date();
            $DateCreR = myDate.getTime();
            window.location.href = "Commande_result.php";
            $EtatR = "ouvert";
            $SyntheseR = "";
            <?php
                $insertSQL = "INSERT INTO Rapports(NumeroR, TitreR, DateCreR, EtatR, SyntheseR) VALUES('$NumeroR','$Titre','$DateCreR','$EtatR','$SyntheseR')"; 
                $crExecSQL = mysqli_query($cx, $insertSQL);

                if ($crExecSQL == TRUE) {
                    echo '<script language="JavaScript">;alert("La commande de la création de rapport de numéro '$NumeroR' pour le titre '$Titre' a été fait.";location.href="Fonct_Principe.html")</script>;';
                } else {
                    echo '<script language="JavaScript">;alert("'mysqli_error($cx)', Inscription impossible !")</script>;';
                }
            ?>
        }
    </script>
</body>


</html>