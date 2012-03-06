<?php
	
	/* Si les donnees du formulaire n'ont pas étés envoyées */
	if (isset($_POST['envoi']) == false) 
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
				</td>
				</form>
			</tr>
		</table>
		<div align="center">
			<a href="inscription.php">
				Inscription
			</a>
		</div>';

	}
	else /* Sinon il faut les traiter */
	{

		$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '');
		$reponse = $bdd->query('SELECT * FROM compte');
		
		$connexion = false;
		$donnees = $reponse->fetch(); // fetch() renvoie l'enregistrement suivant des résultat de la requete ou false s'il n'y en pas
		
		while ($connexion == false && $donnees != false) // Tant qu'on est pas identifié et qu'il y reste des enregistrements
		{
		
			if ($_POST["id"] == $donnees["Identifiant"] && $_POST["mdp"] == $donnees["Pass"]) 
			{
			
				$connexion = true;
				echo '
					<div align="center">
						Bienvenue '.$_POST["id"].'
					</div>
					<div id="conteneur" align="center">
						<script src="cassebrique.js">
						</script>
						<canvas id="canvasElem"  width="800" height="600">
						</canvas>
					<div>
				';
			}
			else
				$donnees = $reponse->fetch(); // On passe au suivant.
			
		}
		
		if ($connexion == false) // Si l'identification a échouée on renvoie le formulaire plus un message d'erreur
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
					</td>
					</form>
				</tr>
				<tr>
					<td colspan="3" align="center">Erreur d\'identification</td>
				</tr>
				</table>
				<div align="center">
					<a href="inscription.php">
						Inscription
					</a>
				</div>';
			
		}
		
	}
		
?>