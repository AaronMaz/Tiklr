<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<HTML>
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Inscription - Site projet annuel</title>
	</HEAD>
	<BODY>

		
	<?php				
	
	function testIdentifiant($id) {
	
		if (empty($id)) 
			return 1;
			
		else {
			/*Il faut au moins 1 lettre pour être valide
			donc des qu'on trouve autre chose qu'un chiffre, on valide
			*/
			
			for ($i=0 ; $i<strlen($id) ; $i++) {
			
				if (is_numeric($id[$i]) == false)
					return 0;
			}
			
			return 2;
		}
	}

	function testPasse($mdp) {
	
		if (empty($mdp))
			return 1;
		else if (strlen($mdp) < 6) 
			return 2;
		else
			return 0;
	
	}
	
	function testPasseCopie($mdp, $mdpCopie) {
	
		if (empty($mdpCopie))
			return 1;
		else if (strcmp($mdp, $mdpCopie) != 0)
			return 2;
		else
			return 0;
	
	}
	
	if (isset($_POST["envoi"]) == false) {
	
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
				<td>Retapez le mot de passe</td>
				<td><input type="text" name="mdp2"></td>
			</tr>
			<tr>
				<td>Pays</td>
				<td><select name="pays">
					<option>France</option>
					<option>Angleterre</option>
					<option>Etats-Unis</option>
					<option>Allemagne</option>
				</td>
			</tr>
			<tr>
				<td>Région</td>
				<td><select name="region">
					<option>A remplir...</option>
				</td>
			</tr>
			<tr>
				<td>Sexe</td>
				<td><select name="sexe">
					<option>Masculin</option>
					<option>Feminin</option>
				</td>
			</tr>
			<tr>
				<td>Age</td>
				<td><input type="text" name="age"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="envoi"></td>
			</tr>
			</form>
			</table>';
	
	} 	
	else {
		
		$idValideCode = testIdentifiant($_POST["id"]);
		$mdpValideCode = testPasse($_POST["mdp"]);
		$mdpCopieValideCode = testPasseCopie($_POST["mdp"], $_POST["mdp2"]);
			
		if ($idValideCode != 0 || $mdpValideCode != 0) {
		
			echo '<table align="center">
				<form action="inscription.php" method="post">
				<tr>
					<td>Identifiant</td>
					<td><input type="text" name="id"></td>';
				if ($idValideCode == 1)
					echo '<td>Ce champ est vide</td>';
				else if ($idValideCode == 2)
					echo '<td>Ce champ doit comporter au moins 1 lettre</td>';

			
			echo '</tr><tr>
					<td>Mot de passe</td>
					<td><input type="text" name="mdp"></td>';
				if ($mdpValideCode == 1) 
					echo '<td>Ce champ est vide</td>';
				else if ($mdpValideCode == 2)
					echo '<td>Ce champ doit comporter au moins 6 carateres</td>';

				
			echo '</tr>
					<tr>
						<td>Retapez le mot de passe</td>
						<td><input type="text" name="mdp2"></td>';
						if ($mdpCopieValideCode == 1)
							echo '<td>Ce champ est vide</td>';
						else if ($mdpCopieValideCode == 2)
							echo '<td>Il y a une erreur dans le mot de passe</td>';
					
					echo '</tr>
					<tr>
						<td>Pays</td>
						<td><select name="pays">
							<option>France</option>
							<option>Angleterre</option>
							<option>Etats-Unis</option>
							<option>Allemagne</option>
						</td>
					</tr>
					<tr>
						<td>Région</td>
						<td><select name="region">
							<option>A remplir...</option>
						</td>
					</tr>
					<tr>
						<td>Sexe</td>
						<td><select name="sexe">
							<option>Masculin</option>
							<option>Feminin</option>
						</td>
					</tr>
					<tr>
						<td>Age</td>
						<td><input type="text" name="age"></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" name="envoi"></td>
					</tr>
					</form>
				</table>';
		}	
		else {
		
			$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '');	
			
			$insertion = $bdd->prepare( 'insert into compte values (?, ?, ?, ?, ?, ?)' );
			$insertion->execute( array($_POST["id"], $_POST["mdp"], $_POST["pays"], $_POST["region"], $_POST["sexe"], $_POST["age"]) );
			
			$reponse =  $bdd->query('SELECT * FROM compte');
			
			// On affiche chaque entrée une à une
			while ($donnees = $reponse->fetch())
				echo $donnees["Identifiant"].' : '.$donnees["Pass"].' : '.$donnees["Pays"].' : '.$donnees["Region"].' : '.$donnees["Sexe"].' : '.$donnees["Age"].'<br>';
				
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