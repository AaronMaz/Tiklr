<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<HTML>
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Inscription - Site projet annuel</title>
	</HEAD>
	<BODY>

		
	<?php	

	if (!isset($_POST['envoi'])) {
	
		echo '<table align="center">
			<form action="inscription.php" method="post">
			<tr>
				<td>Identifiant</td>
				<td><input type="text" name="id"></td>
			<tr>
				<td>Mot de passe</td>
				<td><input type="text" name="mdp"></td>
			</tr>
			<tr>
				<td>Nom</td>
				<td><input type="text" name="nom"></td>
			</tr>
			<tr>
				<td>Prenom</td>
				<td><input type="text" name="prenom"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="envoi"></td>
			</tr>
			</form>
			</table>';
	
	} 	
	else {

		$idValide = true;
		$mdpValide = true;
		
		if (!isset($_POST["id"]) || empty($_POST["id"]))
			$idValide = false;
			
		if (!isset($_POST["mdp"]) || empty($_POST["mdp"]))
			$mdpValide = false;
			
		if (!$idValide || !$mdpValide) {
		
			echo '<table align="center">
				<form action="inscription.php" method="post">
				<tr>
					<td>Identifiant</td>
					<td><input type="text" name="id"></td>';
			if (!$idValide)
				echo '<td>Champ vide</td>';
					
			echo '</tr><tr>
					<td>Mot de passe</td>
					<td><input type="text" name="mdp"></td>';
			if (!$mdpValide)
				echo '<td>Champ vide</td>';
				
			echo '</tr>
					<tr>
						<td>Nom</td>
						<td><input type="text" name="nom"></td>
					</tr>
					<tr>
						<td>Prenom</td>
						<td><input type="text" name="prenom"></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" name="envoi"></td>
					</tr>
					</form>
				</table>';
		}	
		else {
		
			//$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '');
			
			try	{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', $pdo_options);
			}
			catch (Exception $e) {
					die('Erreur : ' . $e->getMessage());
			}
			
			$mdp = $_POST["mdp"];
			$id = $_POST["id"];
			
			$bdd->exec('insert into compte values ( \' '.$id.' \', \' '.$mdp.'\')');
			
			$reponse =  $bdd->query('SELECT * FROM compte');
			
			// On affiche chaque entrée une à une
			while ($donnees = $reponse->fetch())
				echo $donnees["Identifiant"].' : '.$donnees["Pass"].'<br>';
				
			echo '
				<div align="center">
					Vos informations ont été enregistrées
					<br>
					<a href="index.php">
						Retour
					</a>
				</div>';
			
			$reponse->closeCursor(); // Termine le traitement de la requête
		}

	}
		
	?>
	
	</BODY>
</HTML>