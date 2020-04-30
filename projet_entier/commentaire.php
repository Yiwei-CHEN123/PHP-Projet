<?php
    require ("Fonction_utile.php");
    $cx = connexion();
    SESSION_start();
    // $NumeroR = $_SESSION['NumeroR'];
	$num_rapport = filter_input(INPUT_GET, 'num_rapport', FILTER_VALIDATE_INT);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Commentaires</title>
        <link rel="stylesheet" href="style1.css">
    </head>
    <body id="body0">
	<a href="rapport.php?num_rapport=<?php echo $_SESSION['NumeroR'];?>">Retour à la page de rapport</a>
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
                $sqlcommentaire = "SELECT S.IDSuivi, S.DateHeure, P.NomPoste , S.Commentaire "
				. "FROM suiviEdition S,employes E,postes P "
				. "WHERE P.IDPoste=E.IDPoste and S.MatriculeE=E.MatriculeE and S.NumeroR=".$_SESSION['NumeroR']." order by S.DateHeure DESC";
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
 <form action="AjouterCommentaire.php?num_rapport=<?php echo $num_rapport;?>">
 
 <input type="text" name="contenuC" value="" />
 
 <input type="submit" value="Ajouter le commentaire" />
 </form>
   </body>
</html>


