<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<HTML>
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Accueil - Site projet annuel</title>
	</HEAD>
		<style type="text/css">
			#canvasElem{
				border-style:solid;
				border-width:1px;
				background-color:rgb(200, 200, 200);
			}
			</style>
	<BODY>

	<?php	

		if (isset($_POST['mdp']) && isset($_POST["id"])) {
		
			$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '');
			$reponse =  $bdd->query('SELECT * FROM compte');
			
			$connexion = false;
			// On teste chaque entrée une à une
			while ($connexion == false && $donnees = $reponse->fetch()) {
			
				if ($_POST["id"] == $donnees["Identifiant"] && $_POST["mdp"] == $donnees["Mot de passe"]) {
				
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
			}
			if ($connexion == false) {
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
		else {
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
		
	?>

	
	</BODY>
</HTML>