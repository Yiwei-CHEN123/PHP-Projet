<?php
	session_start();
	require("fonction_utile.php");
	$cx = connexion();
?>

<!DOCTYPE HTML>

<html>
	<head>
		<title>Lagard&egrave;re Active</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body id="bodyIndex">
		<h1>Lagard&egrave;re Active</h1>
		<h2>Je possède un compte en ligne</h2>
		
		<form method="get" action="">
			<p>Adresse e-mail *</p>
			<p><input type="email" name="email" required></p>
			<p>Mot de passe *</p>
			<p><input type="text" name="password" required></p>
			<p><input type="submit" id="btnconnecter" name="btnconnecter" value="Se connecter"></p>
			<p>Vous n'&ecirc;tes pas encore membre? <a href="inscription.php">Inscrivez-vous ici</a></p>

			<?php
				/* une fois le bouton "Se connecter" est cliqué, démarrer les précédure suivantes pour
				   vérifier les informations fournies par utilisateur*/
				if (isset($_GET['btnconnecter'])){
					$email = $_GET['email'];
					$pwd = $_GET['password'];
					
					$trouveUser = "SELECT * FROM Employes WHERE AdrEmailE = '$email'";
					$curseur = $cx->query($trouveUser);

					$reqsql = "SELECT * FROM Employes WHERE (AdrEmailE ='$email') AND (MotPasseE = '$pwd' )";
					$ressql = $cx->query($reqsql);

					if ($curseur->num_rows>0){ //vérifier si le compte existe déjà dans BD
						if ($ressql) {
							if ($ressql->num_rows>0){ //vérifier l'adresse email et le mot de passe
								if ($curseur == FALSE) {
						            // si la connexion est en échec 
						            die("Erreur sélection service : ".mysqli_error($cx));
						        } else {
						            //sauvgarder des données suivantes pour les partager entre des pages
						            while ($nuplet = mysqli_fetch_array($curseur)) {
										$_SESSION['email'] = $nuplet['AdrEmailE'];
                                        $_SESSION['mdp'] = $nuplet['MotPasseE'];
                                        $_SESSION['IDPoste'] = $nuplet['IDPoste'];
                                        $_SESSION['MatriculeE'] = $nuplet["MatriculeE"];
						            }  
						        }
						        // si l'adresse email et le mot de passe correspondent, passer à la page des fonctionnalités
								echo '<script type="text/javascript">';
								echo 'window.location.href="fonct_principe.php"';
								echo '</script>';
					        }
					        else{
					        	// si l'adresse email et le mot de passe ne correspondent pas, alerter l'utilisateur et retourner à la page d'accueil
					        	echo '<script language="JavaScript">';
					        	echo 'alert("L\'adresse email et le mot de passe ne correspondent pas!");location.href="index.php"';
					        	echo '</script>;';
					        }
						} 
					}else{
						// si l'adresse email n'est jamais enregistré pour un compte, alerter l'utlisateur
						echo '<script language="JavaScript">';
						echo 'alert("Compte n\'existe pas")';
						echo '</script>';
					}	
				}
			?>
		</form>
	</body>
</html>
