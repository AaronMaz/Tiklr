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
	
	if (!isset($_POST["id"]) && !isset($_POST["mdp"])) {
	
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
				<td>Entrez le Mot de Passe une seconde fois</td>
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
		
		$idValideCode = testIdentifiant($_POST["id"]);
		$mdpValideCode = testPasse($_POST["mdp"]);
		
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
						<td>Entrez le Mot de Passe une seconde fois</td>
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