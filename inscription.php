<?php
	require("Fonction_utile.php");

	$cx = connexion();
?>

<!DOCTYPE HTML>

<html>
	<head>
		<title>Lagard&egrave;re Active</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body id="body0">
		<h1>Lagard&egrave;re Active</h1>
		<p>Veuillez fournir les informations suivantes:</p>
		
		<form method="get" action="">
			<p>Adresse e-mail:<input type="email" name="email" required></p>
			<p>Nom:<input type="text" name="nom" required></p>
			<p>Pr&eacute;nom:<input type="text" name="prenom" required></p>
			<p>Poste:

				<?php 
			        $requete = "SELECT IDPoste, NomPoste FROM Postes ORDER BY 1";
			        $curseur = mysqli_query($cx, $requete);

			        if ($curseur == FALSE) {
			            // si la connexion est en échec 
			            die("Erreur sélection service : ".mysqli_error($cx));
			        } else {
			            echo '<select name = "select">';
			            echo '<option disabled selected value="0">default</option>';
			            while ($nuplet = mysqli_fetch_array($curseur)) {
			            	$id = $nuplet["IDPoste"];
			                echo '<option name = "opt_serv" value= "'.$nuplet["IDPoste"].'">';
			                echo $nuplet["NomPoste"];
			                echo '</option>';
			            }
			            echo("</select>");
			        }
			    ?>

				</p>

			<p>Mot de passe:<input type="text" name="password" required></p>
			<p>Comfirmez mot de passe:<input type="text" name="cpassword" required></p>
			<p><input type="submit" name="btnInscription" value="Je m'inscris"></p>		
		</form>

		<?php
			if (isset($_GET['btnInscription'])){
				$email = $_GET['email'];
				$nom = $_GET['nom'];
				$prenom = $_GET['prenom'];
				$pwd = $_GET['password'];
				$cpwd = $_GET['cpassword'];
				$idPoste = $_GET['select'];

				$trouveUser = "SELECT * FROM Employes WHERE AdrEmailE = '$email'";
				$curseur = $cx->query($trouveUser);

				$reqsql = "SELECT * FROM Employes WHERE (AdrEmailE ='$email') AND (MotPasseE = '$pwd' )";
				$ressql = $cx->query($reqsql);

				if ($curseur){
					if ($curseur->num_rows>0){
						echo "Vous vous &ecirc;tes d&eacute;j&agrave; inscrit. Vous pouvez vous connecter directement.";
						echo '<a href = "login.php">';
						echo "Connectez-vous.";
						echo '</a>';
					}else{
							if ($pwd == $cpwd){
								//trouver le max MatriculeE dans le tableau Employes
								$maxMatricule = "SELECT MAX(MatriculeE) as maxm FROM Employes";
								$resMax = mysqli_query($cx, $maxMatricule);

								if ($resMax){
									if ($resMax->num_rows>0){
										$rows = $resMax->fetch_array();
											//print_r($rows);
											//echo $rows['maxm'];
									}
								}

								$matricule = $rows['maxm'] + 1;

								//insertion donnees dans BD
								$insertSQL = "INSERT INTO Employes (MatriculeE, NomE, PrenomE, AdrEmailE, MotPasseE, IDPoste) VALUES(?, ?, ?, ?, ?, ?)";          
				            	$ordreInsert = mysqli_prepare($cx, $insertSQL);
				            	$rstAffectationVars = mysqli_stmt_bind_param($ordreInsert, "issssi", $matricule, $nom, $prenom, $email, $pwd, $idPoste);

				            	if ($rstAffectationVars == FALSE) {
						            echo("Probleme dans l'affectation des valeurs pour la requete "
						            . "paramétrée : " . mysqli_error($cx));
						        }

						        $crExecSQL = mysqli_stmt_execute($ordreInsert);


								//passer a la page login
								echo "L'inscription r&eacute;ussie.";
								echo '<a href = "login.php">';
								echo "Connectez-vous.";
								echo '</a>';
							} else {
								echo '<script language="JavaScript">';
					        	echo 'alert("Vos deux mots de passe ne correspondent pas!");location.href="inscription.php"';
					        	echo '</script>;';
						} 
					}
				}
				
			}
		?>

	</body>
</html>
