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
		<h2>Je possède un compte en ligne</h2>
		
		<form method="get" action="">
			<p>Adresse e-mail *</p>
			<p><input type="email" name="email" required></p>
			<p>Mot de passe *</p>
			<p><input type="text" name="password" required></p>
			<p><input type="submit" id="btnconnecter" name="btnconnecter" value="Se connecter"></p>
			<p>Vous n'&ecirc;tes pas encore membre? <a href="inscription.php">Inscrivez-vous ici</a></p>

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
								echo '<script type="text/javascript">';
//type de fichier a modifier
								echo 'window.location.href="Fonct_Principe.html"';
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