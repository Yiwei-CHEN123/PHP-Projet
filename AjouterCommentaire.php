<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <p>
            <?php
		require ("Fonction_utile.php");
		$num_rapport = filter_input(INPUT_GET, 'num_rapport', FILTER_VALIDATE_INT);

           SESSION_start();
            $cx = connexion(); 
	    $MatriculeE=$_SESSION['MatriculeE'];
	    $NumeroR=$_SESSION['NumeroR'];
            $countenu = filter_input(INPUT_GET, "contenuC", FILTER_SANITIZE_SPECIAL_CHARS);     
            $temps=date("Y-m-d H:i:s");
			$sqlIDmax = "SELECT max(IDSuivi) as ID FROM SuiviEdition";
			$curseur = mysqli_query($cx, $sqlIDmax);
			if ($curseur == FALSE) {
            die("erreur fonction recherche commentaires : " . mysqli_error($cx));
            } 
			else {                         

				if ($curseur->num_rows>0){
				$rows = $curseur->fetch_array();
										
				}
				}

				$ID = $rows['ID'] + 1;
			
                $insertSQL = "INSERT INTO suiviedition(IDSuivi, DateHeure, Commentaire, MatriculeE, NumeroR) " 
                        ." VALUES('$ID', '$temps', '$countenu','$MatriculeE','$NumeroR')";

         
                $crExecSQL = mysqli_query($cx, $insertSQL);


                if ($crExecSQL == TRUE) {
                    
                   header("location:commentaire.php?num_rapport=<?php echo $num_rapport;?>"); 
                } else {
                    echo(mysqli_error($cx));
                    echo("<br/>");
                    echo("Ajouter impossible");
					
                }
 
            ?>
        </p>
    </body>
</html>
