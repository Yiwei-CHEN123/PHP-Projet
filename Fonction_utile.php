<?php
// Définition des constantes de connexion
define("ID_MYSQL", "root");
define("PASSE_MYSQL", "");
define("HOST_MYSQL", "localhost");
define("BD_MYSQL", "BDD_ProjetPHP");



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
            return $cx;
        }
    }
}


// Retrouver une requête à l'aide de son IDIndi (car il est unique)
/* connexion en param entrée
 * IDIndi en param entrée
 * requête en sortie
*/

function retrouverRequete($cx,$IDIndi) {
    $sqlRequete = "SELECT Requete FROM Indicaterus WHERE IDIndi = '$IDIndi'";

    $curseur = mysqli_query($cx, $sqlRequete);
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

// Retrouver la poste d'un employé par son email
/* connexion en param entrée
 * AdrEmailE en param entrée
 * IDPoste en sortie
 */

 function retrouverPoste($cx,$AdrEmailE) {
     $sqlNomPoste = "SELECT P.NomPoste 
                    FROM Poste P
                    WHERE P.IDPoste in ( SELECT P1.IDPoste 
                                         FROM Employes E, Poste P1
                                         WHERE P1.IDPoste = E.IDPoste
                                         AND E.AdrEmailE = '$AdrEmailE' ); ";
    
    $curseur = mysqli_query($cx,$sqlNomPoste);
    if ($curseur == FALSE) {
        die("Erreur fonction retrouverEmail");
    } else {
        if (mysqli_num_rows($curseur) == 0)  {
            return NULL;
        } else {
            return mysqli_fetch_array($curseur);
        }
    }
 }
