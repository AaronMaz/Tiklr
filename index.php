<?php
	session_start();
	
	if (isset($_SESSION["nonConnecte"]) == false)
		$_SESSION["nonConnecte"] = 1; // Lors du chargement initial, on n'est pas connecté
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Accueil - Tiklr</title>
	</head>
		<style type="text/css">
			#canvasElem{
				border-style:solid;
				border-width:1px;
				background-color:rgb(200, 200, 200);
			}
			</style>
	<body>

	<?php
		
		if (isset($_SESSION['nonConnecte']))
			echo '$_SESSION["nonConnecte"] est déclarée et vaut '.$_SESSION["nonConnecte"].'<br>';
		else
			echo '$_SESSION["nonConnecte"] n\'est pas déclarée.';
			
			
		if ($_SESSION["nonConnecte"]) // Si l'on n'est pas encore connecte
		{
			//include("connexion.php");
			/* Si les donnees du formulaire ont étés envoyées, il faut les traiter */
			if (isset($_POST['envoi']) == true) 
			{

				$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '');
				$reponse = $bdd->query('SELECT * FROM compte');
				
				$connexion = false;
				$donnees = $reponse->fetch(); // fetch() renvoie l'enregistrement suivant des résultat de la requete ou false s'il n'y en pas
				
				while ($_SESSION["nonConnecte"] != 0 && $donnees != false) // Tant qu'on est pas identifié et qu'il y reste des enregistrements
				{
				
					if ($_POST["id"] == $donnees["Identifiant"] && $_POST["mdp"] == $donnees["Pass"])
						$_SESSION["nonConnecte"] = 0;
					else
						$donnees = $reponse->fetch(); // On passe au suivant.
						
				}
				
				if ($_SESSION["nonConnecte"]) // Si l'identification a échouée on renvoie le formulaire plus un message d'erreur
					$_SESSION["nonConnecte"] = 2;
				
			}
		}
		
		if ($_SESSION["nonConnecte"]) // Le formulaire n'a pas été validé par l'user
		{
			echo '
				<table align="center" frame="void" rules="cols" cellpadding="5px" border="1px">
					<tr>
						<th>Identifiant</th>
						<th>Mot de passe</th>
						<th>Valider</th>
					</tr>
					<tr>
						<form action="index.php" method="post">
						<td>
							<input type="text" name="id">
						</td>
						<td>
							<input type="text" name="mdp">
						</td>
						<td>
							<input type="submit" name="envoi">
						</td>';
						
			if ($_SESSION["nonConnecte"] == 2) // Le formulaire est rempli mais incorrect 
				echo '<tr>
						<td colspan="3" align="center">Erreur d\'identification</td>
					</tr>';
					
			echo '
						</form>
					</tr>
				</table>
				<div align="center">
					<a href="inscription.php">
						Inscription
					</a>
				</div>';
		}
		else
		{
			
			echo 'Vous etes connecté';
			echo '<a href="deconnexion.php">Deconnexion</a>';
							/*echo '
					<div align="center">
						Bienvenue '.$_POST["id"].'
					</div>
					<div id="conteneur" align="center">
						<script src="cassebrique.js">
						</script>
						<canvas id="canvasElem"  width="800" height="600">
						</canvas>
					<div>
				';*/
		}

		echo '<br><br>SECOND PASSAGE<br>';
		
		if (isset($_SESSION['nonConnecte'])) 
			echo '$_SESSION["nonConnecte"] est déclarée et vaut '.$_SESSION["nonConnecte"];
		else
			echo '$_SESSION["nonConnecte"] n\'est pas déclarée.';
	?>
		

	
	</body>
</html>