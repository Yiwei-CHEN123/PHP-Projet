<?php
// charger le fichier des fonctions
require("fonction_utile.php");

// executer la fonction de connexion
$cx = connexion();
session_start();
$service = filter_input(INPUT_POST, "select", FILTER_SANITIZE_SPECIAL_CHARS);
$indicateur = filter_input(INPUT_POST, "select2", FILTER_SANITIZE_SPECIAL_CHARS);

//$IDPoste = filter_input(INPUT_POST, "select", FILTER_SANITIZE_SPECIAL_CHARS);

//for ($i = 0; $i<= count($_SESSION["indicateur"])-1; $i++) {
    //echo ("<p>");
    //echo ($_SESSION["indicateur"][$i]);
    //echo ("<p>");
//}
//$session_indi = array();
//if (array_key_exists("indicateur",$_SESSION)) {
    //if ($_SESSION["indicateur"] != null ) {
        //$session_indi = $_SESSION["indicateur"];
    //}
//}
?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <title>La page de résultat de la commande</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style1.css">
</head>

<body id="body0">
    <a href="fonct_principe.php">Retour</a>
    <h1>Le résultat de la commande </h1>
    
    <?php
        // Vérifier si les formulaires dans la page précédente sont bien remplies
        $TitreR = filter_input(INPUT_POST, "titreR", FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($_POST['select'])) {           
            if (isset($_POST['opt_indi'])) {              
                if ($TitreR != NULL) {
                    $_SESSION["service"] = $_POST['select'];
                    $_SESSION["indicateur"] = $_POST['opt_indi']; 
                    //trouver il y a combien de rapports sont déjà dans la table Rapports
                    $maxNumeroR = "SELECT MAX(NumeroR) as MaxNR FROM Rapports";
                    $resmax = mysqli_query($cx,$maxNumeroR);

                    if ($resmax) {
                        if ($resmax->num_rows>0){
                            //$maxNumR = $resmax->fetch_array();
                            $maxNumR = mysqli_fetch_array($resmax);
                        }
                    } else {
                        die("Erreur sélection maxNumeroR : ".mysqli_error($cx));
                    }

                    $NumeroR = $maxNumR['MaxNR'] + 1;
                    $EtatR = "Création du rapport";
                    $SyntheseR = "";
                    $DateCreR = date("Y-m-d H:i:s");
                    // Insertion du nouveau rapport crée par l'utilisateur dans la base de données
                    $insertSQL = "INSERT INTO Rapports(NumeroR, TitreR, DateCreR, Etat, SyntheseR) VALUES(?,?,?,?,?)"; 

                    $crPreSQL = mysqli_prepare($cx, $insertSQL);
                    $affExecSQL = mysqli_stmt_bind_param($crPreSQL,"issss",$NumeroR,$TitreR,$DateCreR,$EtatR,$SyntheseR);
                    
                    if ($affExecSQL == FALSE) {
                        echo ("Probleme dans l'affectation des valeurs pour la requete "
                        . "paramétrée de la table Rapports: ".mysqli_error($cx));
                        echo ("</br>");
                    }

                    $crExecSQL = mysqli_stmt_execute($crPreSQL);
                    if ($crExecSQL == TRUE) {
                        echo ("La création de rapport de numéro ".$NumeroR." pour le titre ".$TitreR." a été fait.");
                        echo ("</br>");
                    } else {
                        echo ("Erreur de la création de rapport : ".mysqli_error($cx));
                        echo ("</br>");
                    }

                    $NomPoste = retrouverNomPoste($cx,$_SESSION["service"]);
                    $MatriculeE = retrouverMatriculeE($cx,$_SESSION['email']);

                    // Insertion de la nouvelle commande crée par l'utilisateur dans la base de données
                    $insertServiceSQL = "INSERT INTO Demander(IDPoste, NumeroR, MatriculeE) VALUES(?,?,?) ";
                    $crPreServiceSQL = mysqli_prepare($cx,$insertServiceSQL);
                    $affExecServiceSQL = mysqli_stmt_bind_param($crPreServiceSQL,"iii",$_SESSION["service"],$NumeroR,$MatriculeE);
                    
                    if ($affExecServiceSQL == FALSE) {
                        echo ("Probleme dans l'affectation des valeurs pour la requete "
                        . "paramétrée de la table Demander: ".mysqli_error($cx));
                        echo ("</br>");
                    }

                    $NomE = retrouverNomE($cx,$MatriculeE);
                    $PrenomE = retrouverPrenomE($cx,$MatriculeE);
                    $crExecServiceSQL = mysqli_stmt_execute($crPreServiceSQL);
                    if ($crExecServiceSQL == TRUE) {
                        echo ("La commande du rapport de numéro ".$NumeroR." pour le titre ".$TitreR." effectuée par ".$PrenomE." ".$NomE." affecté pour le ".$NomPoste." a été fait.");
                        echo ("</br>");
                    } else {
                        echo ("Erreur de la commande de rapport : ".mysqli_error($cx));
                        echo ("</br>");
                    }

                    // Insertion des indicateurs choisis par l'utilisateur avec le rapport liée dans la base de données
                    $insertIndiSQL = "INSERT INTO Comporter(IDIndi,NumeroR) VALUES(?,?)";
                    
                    //$IDIndi = array();
                    //for ($i = 0; $i<= (count($_SESSION["indicateur"])-1); $i++) {
                        //$IDIndi = retrouverIDIndi($cx,$_SESSION["indicateur"][$i]);
                    //}
                    
                    $crPreIndiSQL = mysqli_prepare($cx,$insertIndiSQL);
                    
                    for ($i = 0; $i<= (count($_SESSION["indicateur"])-1); $i++) {
                        $NomIndi = retrouverNomIndi($cx,$_SESSION["indicateur"][$i]);
                        $resExecIndiSQL = mysqli_stmt_bind_param($crPreIndiSQL,"ii",$_SESSION["indicateur"][$i],$NumeroR);

                        if ($resExecIndiSQL == FALSE) {
                            echo ("Probleme dans l'affectation des valeurs pour la requete "
                            . "paramétrée de la table Comporter: ".mysqli_error($cx));
                            echo ("</br>");
                        }
                        
                        $crExecIndiSQL = mysqli_stmt_execute($crPreIndiSQL);
                        if ($crExecIndiSQL == TRUE) {
                            echo ("L'insertion de l'indicateur ".$NomIndi." dans le rapport de numéro ".$NumeroR." pour le titre ".$TitreR." a été fait.");
                            echo ("</br>");
                        } else {
                            echo ("Erreur de l'insertion de l'indicateur dans le rapport: ".mysqli_error($cx));
                            echo ("</br>");
                        }           
                    }
                } else {
                    echo '<script language="JavaScript">';
		            echo 'alert("Erreur : Vous n\'avez pas encore déterminé le titre de rapport !");history.back();';
                    echo '</script>;';
                    //die("Erreur : Vous n'avez pas encore déterminé le titre de rapport ! ");
                }               
            } else {
                echo '<script language="JavaScript">';
		        echo 'alert("Erreur : Vous n\'avez pas encore sélectionné l\'indicateur !");history.back();';
                echo '</script>;';
                //die("Erreur : Vous n'avez pas encore sélectionné l'indicateur ! ");
            }          
        } else {
                echo '<script language="JavaScript">';
	            echo 'alert("Erreur : Vous n\'avez pas encore sélectionné le service !");history.back();';
	            echo '</script>;';
            //die("Erreur : Vous n'avez pas encore sélectionné le service ! ");
        }
    ?>

</body>

</html>
