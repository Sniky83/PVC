<?php
	class c_affichage{
		//Structure de base
		public function afficherStructure($status, $resultat, $res){
			echo '
			<body>
				<div id="parent">
					<div id="logo"></div>
					<header id="banniere"></header>
					<nav id="menu">
						<ul>
							<li><a href="./index.php">Accueil</a></li>
					';
					if(isset($_SESSION['log']) && !empty($_SESSION['log'])
					&& $status == 2)
					{
						if($res == 1 || $status != 2)
						{
							echo '<li><a href="./reservation.php">Reservation</a></li>';
						}
					}

					if(isset($_SESSION['log']) && !empty($_SESSION['log'])
					&& $status != 0)
					{
						echo '<li><a href="./mesures.php">Mesures</a></li>';
					}

					if(isset($_SESSION['log']) && !empty($_SESSION['log']) && $status == 2 && $resultat == '')
					{
						echo '
							<br/>
							<b>Aucune réservation de prévu</b>
						';
					}
					else
					{
						if(isset($_SESSION['log']) && !empty($_SESSION['log']) && $status == 2 && $resultat != '')
						{
							echo '
							<div id="reservation">
								<br/>'.$resultat.
							'</div>'
							;
						}
					}

					if(isset($_SESSION['log']) && !empty($_SESSION['log']))
					{
						echo '
						<p>Bonjour, <i><b>'.$_SESSION['log'].'</b></i></p>
						<form action="./deconnexion.php">
							<input type="submit" value="Se déconnecter">
						</form>
						';
					}
					else
					{
						echo '<br/><a href="./connexion.php">Se connecter</a>';
					}

					echo '
						</ul>
					</nav>
					<div id="contenu">
				';
		}
		//Page Index
		public function afficherIndex($flash){
			echo $flash;
			echo '
						<h1>Présentation du site</h1>
						<p class="align-center">Bienvenu sur notre site, nous proposons un système de consultation des mesures
						sur chaque véhicule de chaque équipe.<br/>
						Une équipe est une marque de voiture ex: Audi ou Renault.<br/>
						Les chefs d\'équipes auront la possibilité de faire une réservation pour peser leurs véhicules
						et pouront consulter les mesures de leur équipe en fonction du type de mesure (sans essence - sans pilote, avec conducteur - sans pilote etc).<br/>
						Les membres d\'une équipe auront simplement la possibilité de visionner les mesures de leurs véhicules.</p>
						<img class="displayed" src="./images/voiture.jpg" alt="voiture de course" width="800" height="600" />
						<br/>
					</div>
				</div>
			';
		}

		//Page Connexion
		public function afficherFormulaireConnexion(){
				echo '
						<h1>Se connecter</h1>
						<form method="POST">
							<div class="formelement">
								<label for="user" class="blue">Nom de compte</label><br />
								<input type="text" name="username" id="user"/><br />
								<label for="pass" class="lbl blue">Mot de passe</label><br />
								<input type="password" name="password" id="pass"/><br />
							</div>
							<input type="submit" value="Envoyer" id="btn"/>
						</form>
				';
		}

		//Partie affichage head
		public function afficherHeadHTML($title){
			echo '
			<!DOCTYPE html>
			<html lang="fr">
				<head>
					<meta charset="utf-8">
					<title>'.$title.'</title>
					<link rel="stylesheet" href="style.css">
				</head>
			';
		}

		public function afficherReservation(){
			echo '
			<h1>Planning</h1>
			<br/>
			<form method="POST" class="align-center">
				<label for="date">Choisir une date</label><br/>
				<input type="date" name="date" id="date" />
				<br/>
				<br/>
				<select name="periode">
					<option value="">Choisissez une période ...</option>
					<option id="AM" value="AM">Matin (8h à 12h)</option>
					<option id="PM" value="PM">Après-midi (14h à 18h)</option>
				</select>
				<br/>
				<br/>
				<input type="submit" value="Réserver" id="btn">
			</form>';
			if(isset($_POST["date"]) && !empty($_POST["date"])
			&& isset($_POST["periode"]) && !empty($_POST["periode"]))
			{
				$date = $_POST["date"];
				$periode = $_POST["periode"];
				echo "
				<script type='text/javascript'>
					var date = document.getElementById('date');
					date.setAttribute('value','$date');

					var periode = document.getElementById('$periode');
					periode.setAttribute('selected','selected');
				</script>
				";
			}
		}

		public function afficherMesures($model, $resultat, $avd, $avg, $ard, $arg){
			echo '
			<h1>Mesures</h1>
			<br/>
			<form method="POST" class="align-center" id="formulaire">
				<label for="select-voiture">Modèle de la voiture:</label>
				<select id="model" name="vehicule">
				';
				foreach($model as $voiture){
					echo "
					<option id='$voiture[0]' value='$voiture[0]:$voiture[1]'>$voiture[1]</option>
					";
				}
				echo '
				</select>
				<br/>
				<br/>
				<label for="select-mesure">Type de mesures:</label>
				<select name="typeMesure">
					<option id="Se-Ap" value="Se-Ap">Avec Pilote - Sans Essence</option>
					<option id="Ae-Ap" value="Ae-Ap">Avec Pilote - Avec Essence</option>
					<option id="Se-Sp" value="Se-Sp">Sans Pilote - Sans Essence</option>
					<option id="Ae-Sp" value="Ae-Sp">Sans Pilote - Avec Essence</option>
				</select>
				<br/>
				<br/>
				<label for="radio"> Type d\'affichage:</label>
				<input id="tableau" type="radio" name="affichage" value="tableau" checked>
				<label for="tableau">Tableau</label>
				<input id="graphique" type="radio" name="affichage" value="graphique">
				<label for="graphique">Graphique</label>
				<br/>
				<br/>
				';
				if(isset($_POST['affichage']) && $_POST['affichage'] == 'tableau')
				{
					echo '
					<table>
						<tr>
							<td></td>
							<td class="head">AVANT</td>
							<td class="head">ARRIERE</td>
						</tr>
						<tr>
							<td class="head">GAUCHE</td>
							';
							echo "
							<td>$resultat[0] KG</td>
							<td>$resultat[2] KG</td>
						</tr>
						<tr>
							<td class='head'>DROITE</td>
							<td>$resultat[1] KG</td>
							<td>$resultat[3] KG</td>
						</tr>
					</table>
					";
				}
				if(isset($_POST['vehicule']))
				{
					$nomAndId = explode(':', $_POST['vehicule']);
				}
				if(isset($_POST['affichage']) && $_POST['affichage'] == 'graphique')
				{
					if($_POST['typeMesure'] == 'Ae-Ap')
					{
						$type = 'Avec Pilote - Avec Essence';
					}
					elseif($_POST['typeMesure'] == 'Ae-Sp')
					{
						$type = 'Sans Pilote - Avec Essence';
					}
					elseif($_POST['typeMesure'] == 'Se-Ap')
					{
						$type = 'Avec Pilote - Sans Essence';
					}
					elseif($_POST['typeMesure'] == 'Se-Sp')
					{
						$type = 'Sans Pilote - Sans Essence';
					}

					echo "
						<img src='./inc/graph.php?f=afficherGraph&voiture=$nomAndId[1]&type=$type&avg=$avg&avd=$avd&arg=$arg&ard=$ard'>
					";
				}
				if(isset($_POST['typeMesure']) && !empty($_POST['typeMesure']))
				{
					$typeM = $_POST['typeMesure'];
				}
				if(isset($_POST['affichage']) && !empty($_POST['affichage']))
				{
					$typeAff = $_POST['affichage'];
				}
				if(isset($nomAndId[0]) && !empty($nomAndId[0])){
					echo "
						<script type='text/javascript'>
								var vehicule = document.getElementById('$nomAndId[0]');
								vehicule.setAttribute('selected','selected');

								var typeM = document.getElementById('$typeM');
								typeM.setAttribute('selected','selected');

								var typeAff = document.getElementById('$typeAff');
								typeAff.setAttribute('checked','checked');
						</script>
					";
				}
				echo '
				<br/>
				<br/>
				<input type="submit" value="Afficher les valeurs"/>
				<form method="POST">
				<br/>
				<br/>
				<hr>
				<br/>
					<input type="submit" name="csv" value="Télécharger en CSV">
				</form>
				<br/>
				<br/>
				</form>
				</body>
				</html>
				';
		}

	//Fin de la classe
	}
?>
