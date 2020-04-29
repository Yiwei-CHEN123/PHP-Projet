<?php
	session_start();
	require_once('Fonction_utile.php');
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
		<h2>Login</h2>
		
		<form method="get" action="">
			<p>Adresse e-mail *</p>
			<p><input type="email" name="email" required></p>
			<p>Mot de passe *</p>
			<p><input type="text" name="password" required></p>
			<p><input type="submit" name="btnconnecter" value="Se connecter"></p>

			<?php
				if (isset($_GET['btnconnecter'])){
					$email = $_GET['email'];
					$pwd = $_GET['password'];
					
					$trouveUser = "SELECT * FROM Employes WHERE AdrEmailE = '$email'";
					$curseur = $cx->query($trouveUser);

					$reqsql = "SELECT * FROM Employes WHERE (AdrEmailE ='$email') AND (MotPasseE = '$pwd' )";
					$ressql = $cx->query($reqsql);

					if ($curseur->num_rows>0){
						if ($ressql) {
							if ($ressql->num_rows>0){
								if ($curseur == FALSE) {
						            // si la connexion est en échec 
						            die("Erreur sélection service : ".mysqli_error($cx));
						        } else {
						            
						            while ($nuplet = mysqli_fetch_array($curseur)) {
								$_SESSION['mail'] = $nuplet['AdrEmailE'];
                                                                $_SESSION['mdp'] = $nuplet['MotPasseE'];
                                                                $_SESSION['IDPoste'] = $nuplet['IDPoste'];
                                                                $_SESSION['MatriculeE'] = $nuplet["MatriculeE"];
						                // $matricule = $nuplet["MatriculeE"];
								//setcookie('matricule',$matricule);
						                //echo $matricule;
						            }  
						        }

								echo '<script type="text/javascript">';
								echo 'window.location.href="fonct_principe.php"';
								echo '</script>';
					        }
					        else{
					        	echo '<script language="JavaScript">';
					        	echo 'alert("L\'adresse email et le mot de passe ne correspondent pas!");location.href="accueil.php"';
					        	echo '</script>;';
					        }
						} 
					}else{
						echo '<script language="JavaScript">';
						echo 'alert("Compte n\'existe pas")';
						echo '</script>';
					}

					
				}
			?>
		</form>
	</body>
</html>
