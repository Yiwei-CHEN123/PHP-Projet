<?php

session_start();
if(isset($_SESSION['mail']) == FALSE || isset($_SESSION['mdp']) == FALSE) { // Permet de vérifier que l'utilisateur est connecté
    die('Vous devez être connecté pour accéder à cette page. <a href="index.php">Retourner à la page d\'accueil</a>');
}

?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>La fonction principale</title>
</head>

<body>

    <p>Choisissez l'opération que vous voulez faire :</p>
    <a href="commande.php">Faire une commande de rapport</a>
    <a href="liste_rapport.php">Consulter les rapports</a>
    
</body>

</html>
