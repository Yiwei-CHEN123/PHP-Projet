<?php
   // charger le fichier des fonctions
require("fonction_utile.php");

// executer la fonction de connexion
$cx = connexion(); 
session_start();

//$email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_SPECIAL_CHARS);

?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>La fonction principale</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style1.css">
</head>

<body id="body0">

    <p>Choisissez l'opération que vous voulez faire :</p>

    <br/>
    <?php
        // Faire la distinction pour les différents utilisateurs
        $PosteE = retrouverPoste($cx,$_SESSION["email"]);
        if ($PosteE == "Directeur" or $PosteE == "Directeur Adjoint" or $PosteE == "Directeur des ventes") {
            echo '<a href="commande.php">Faire une commande de rapport</a>';
            echo ("<br/>");
            echo '<a href="liste_rapport.php">Consulter les rapports</a>';
        } else {
            echo '<a href="liste_rapport.php">Consulter les rapports</a>';
        } 
        // Faire la session pour conserver l'information du poste d'utilisateur
        $_SESSION['Poste'] = $PosteE;
    ?>

</body>

</html>