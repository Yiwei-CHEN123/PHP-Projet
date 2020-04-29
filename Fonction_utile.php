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

function ListeRapportAnnee($cx, $annee) { // Fonction qui permet de récupérer la liste des rapports en fonction de l'année
        
        $requete = "SELECT NumeroR, TitreR FROM Rapports WHERE DateCreR LIKE '$annee%';";
        $result = mysqli_query($cx, $requete);
                
        if ($result == FALSE) {
            die("<h2 style=\"color: red;\"> Erreur dans la requête </h2></br><a href=\"index.php\">Retour à la page d'accueil</a>");
        } else {
            if (mysqli_num_rows($result) == 0) {
                return NULL;
            } else {
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
        }
}

function ListeIndicateursRapport($cx, $num_rapport) {
    $requete = "SELECT indicateurs.IDIndi, NomIndi, AnalyseIndi, Requete FROM Indicateurs, Comporter WHERE indicateurs.IDIndi = comporter.IDIndi AND NumeroR = '$num_rapport';";
    $result = mysqli_query($cx, $requete);
    
        if ($result == FALSE) {
            die("<h2 style=\"color: red;\"> Erreur dans la requête </h2></br><a href=\"index.php\">Retour à la page d'accueil</a>");
        } else {
            if (mysqli_num_rows($result) == 0) {
                return NULL;
            } else {
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
        }
}

function RenvoyerEtude($cx, $num_rapport) {
    $requete = "UPDATE rapports SET Etat='Ouvert' WHERE NumeroR='$num_rapport';";
    $result = mysqli_query($cx, $requete);
    
        if ($result == FALSE) {
            $msg = 'Le renvoie du rapport a échoué, merci de retenter plus tard';
            return $msg;
        } else {
            $msg = 'Le renvoie du rapport a été effectué avec succès';
            return $msg;
        }
}

function CloturerRapport($cx, $num_rapport) {
    $requete = "UPDATE rapports SET Etat='Cloturer' WHERE NumeroR='$num_rapport';";
    $result = mysqli_query($cx, $requete);
    
        if ($result == FALSE) {
            $msg = 'La cloture du rapport a échouée, merci de retenter plus tard';
            return $msg;
        } else {
            $msg = 'La cloture du rapport a été effectuée avec succès';
            return $msg;
        }
}

function SyntheseRapport($cx, $num_rapport, $text_synthese) {
    $requete = "UPDATE rapports SET SyntheseR='$text_synthese' WHERE NumeroR='$num_rapport';";
    $result = mysqli_query($cx, $requete);
    
        if ($result == FALSE) {
            $msg = 'L\'ajout de la synthese a échoué';
            return $msg;
        } else {
            $msg = 'La synthese a été ajoutée avec succès';
            return $msg;
        }
}

function EnvoyerDirecteur($cx, $num_rapport) {
    $requete = "UPDATE rapports SET Etat='Soumis' WHERE NumeroR='$num_rapport';";
    $result = mysqli_query($cx, $requete);
    
        if ($result == FALSE) {
            $msg = 'L\'envoie du rapport au Directeur a échoué, merci de retenter plus tard';
            return $msg;
        } else {
            $msg = 'Le rapport a été envoyé au Directeur avec succès';
            return $msg;
        }
}

function ListeIndicateursRapportNonPresent($cx, $num_rapport) {
    $requete = "Select IDIndi, NomIndi from indicateurs where IDIndi not in(select IDIndi from comporter where NumeroR='$num_rapport');";
    $result = mysqli_query($cx, $requete);
    
        if ($result == FALSE) {
            die("<h2 style=\"color: red;\"> Erreur dans la requête </h2></br><a href=\"index.php\">Retour à la page d'accueil</a>");
        } else {
            if (mysqli_num_rows($result) == 0) {
                return NULL;
            } else {
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
        }
}

function AjoutIndicPresents($cx, $num_rapport, $IDindi) {
    $requete = "INSERT INTO comporter (IDIndi, NumeroR) VALUES ('$IDindi','$num_rapport');";
    $result = mysqli_query($cx, $requete);
        if ($result == FALSE) {
            $msg = 'L\'indicateur n\'a pas pu être ajouté au rapport';
            return $msg;
        } else {
            $msg = 'L\'indicateur n°'.$IDindi.' a été ajouté au rapport n°'.$num_rapport.' avec succès';
            return $msg;
        }
}

function AjoutNewIndic($cx, $desc_indi, $analy_indi, $rq_indi) {
    $requete = "INSERT INTO indicateurs (NomIndi, AnalyseIndi, Requete) VALUES ('$desc_indi', '$analy_indi', '$rq_indi');";
    $result = mysqli_query($cx, $requete);
        if ($result == FALSE) {
            $msg = 'L\'indicateur n\'a pas pu être ajouté';
            return $msg;
        } else {
            $msg = 'L\'indicateur a été ajouté à la base avec succès';
            return $msg;
        }
}

function ListeIndicateurs($cx) {
    $requete = "Select * FROM indicateurs;";
    $result = mysqli_query($cx, $requete);
    
        if ($result == FALSE) {
            die("<h2 style=\"color: red;\"> Erreur dans la requête </h2></br><a href=\"index.php\">Retour à la page d'accueil</a>");
        } else {
            if (mysqli_num_rows($result) == 0) {
                return NULL;
            } else {
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
        }   
}

function AjoutAnalyseIndic($cx, $txt_analyse, $id_indi) {
    $requete = "UPDATE indicateurs SET AnalyseIndi='$txt_analyse' WHERE IdIndi='$id_indi';";
    $result = mysqli_query($cx, $requete);
    
        if ($result == FALSE) {
            $msg = 'L\'analyse n\'a pas pu être ajouté à l\'indicateur selectionné';
            return $msg;
        } else {
            $msg = 'L\'analyse a bien été ajouté à l\'indicateur selectionné';
            return $msg;
        }
}
