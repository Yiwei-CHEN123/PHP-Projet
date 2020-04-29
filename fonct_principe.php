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
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <p>Choisissez l'opération que vous voulez faire :</p>
    <p><a role="button" class="btn btn-primary" href="commande.php">Faire une commande de rapport</a></p>
    <p><a role="button" class="btn btn-primary" href="liste_rapport.php">Consulter les rapports</a></p>
    
</body>

</html>
