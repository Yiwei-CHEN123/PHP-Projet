
<html>
    <head>
        <meta charset="UTF-8">
        <title>Commentaires</title>
    </head>
    <body>
	<a href="Rapport.php">Retour à la page de rapport</a>
<table border = 1>
<tr>
<td>Heure
</td>
<td>Identifiant
</td>
<td>Message
</td>
</tr>
<?php
require ("Fonction_utile.php");

                $cx = connexion();
                $sqlcommentaire = "SELECT S.IDSuivi, S.DateHeure, P.NomPoste , S.Commentaire "
				. "FROM suiviEdition S,employes E,postes P "
				. "WHERE P.IDPoste=E.IDPoste and S.MatriculeE=E.MatriculeE and S.NumeroR=1001 order by S.DateHeure DESC";
                $curseur = mysqli_query($cx, $sqlcommentaire);

                if ($curseur == FALSE) {
                    die("Erreur sélection statuts : " . mysqli_error($cx));
                }
                // parcour du curseur
                while ($nuplet = mysqli_fetch_array($curseur)) {
                  
					
					echo("<tr>");
				echo("<td>");
                echo($nuplet["DateHeure"]);
				echo("</td>");
				echo("<td>");
                echo($nuplet["NomPoste"]);
				echo("</td>");
				echo("<td>");
                echo($nuplet["Commentaire"]);
				echo("</td>");
                echo("</tr>");
                }
 

 ?> 
 
 </table>
 <form action="AjouterCommentaire.php">
 
 <input type="text" name="contenuC" value="" />
 
 <input type="submit" value="Ajouter le commentaire" />
 </form>
   </body>
</html>


