<?php
// Définition des constantes de connexion
define("ID_MYSQL", "21405091")
define("PASSE_MYSQL", "P00LR5")
define("HOST_MYSQL", "localhost/phpmyadmin")
define("BD_MYSQL", "BDD_ProjetPHP")



// Fonction de connexion, retourne la variable de connexion

function connexion() {
    $cx = mysqli_connect(HOST_MYSQL, ID_MYSQL, PASSE_MYSQL);

    if ($cx == NULL) {
        die("Erreur connexion à MySQL/Maria DB : ".mysqli_connect_error());

    }else {
        //connexion réussie
        if (mysqli_select_db($cx,BD_MYSQL) == FALSE) {
            die("Choix base impossible : ".mysqli_error($cx));

        }else {
            //base est correct - Tout va bien
            return $cx
        }
    }
}


// Retrouver une requête à l'aide de son IDIndi (car il est unique)
/* connexion en param entrée
 * IDIndi en param entrée
 * requête en sortie
*/

function retrouverRequete($cx,$IDIndi) {
    $sqlIDIndi = "SELECT Requete FROM Indicaterus WHERE IDIndi = '$IDIndi";

    $curseur = mysqli_query($cx, $sqlIDIndi);
    if ($curseur == FALSE) {
        die ("Erreur fonction requete");

    } else {
        if (mysqli_num_rows($curseur) == 0) {
            return NULL;
        } else {
            return mysqli_fetch_array($curseur);
        }
    }
}
