<?php
	require_once("./inc/structureBase.php");

	$MyAffichage->afficherHeadHTML("Réservation");

	require_once("./inc/structureBaseBis.php");

	$MyAffichage->afficherReservation();

	$flag = 1;

	if($status != 2)
	{
		header('Location: ./index.php');
	}

	if($res == 0)
	{
		header('Location: ./index.php');
	}

	if(isset($_POST["periode"]) AND !empty($_POST["periode"])
	AND isset($_POST["date"]) AND !empty($_POST["date"]))
	{
		if($_POST["periode"] == 'AM' || $_POST["periode"] == 'PM')
		{
			$check = $MyBDD->checkIfReservationExists($_POST['date'],$_POST['periode']);
			if($check == 1)
			{
				$timestampRes = strtotime($_POST["date"]);
				$timestampNow = time();
				$checkIfBack = $timestampNow - $timestampRes;

				if($checkIfBack < 0)
				{
					$MyBDD->reserver($_POST["periode"],$_POST["date"],$id_equipe);
					$_SESSION['flash'] = '';
					header('Location: ./index.php');
				}
				else
				{
					echo "<h1 class='red'>Vous ne pouvez pas réserver pour une date antérieure ou pour le même jour !</h1>";
				}
			}
			else
			{
				$newDateFormat = date("d-m-Y", strtotime($_POST["date"]));
				echo '<h1 class="red">La réservation est déjà prise pour cette date ('.$newDateFormat.') !</h1>
					<h2 class="red align-center">Essayez de changer la période de la journée</h2>';
			}
		}
		else
		{
			echo '<h1>Interdit !</h1>';
		}
	}
	else
	{
		if(isset($_POST["periode"]) AND empty($_POST["periode"])
		AND isset($_POST["date"]) AND empty($_POST["date"]))
		{
			echo '<h1 class="red">Veuillez entrer une date et séléctionner une période !</h1>';
			$flag = 0;
		}

		if(isset($_POST["periode"]) AND empty($_POST["periode"])
		AND $flag == 1)
		{
			echo '<h1 class="red">Veuillez choisir une période (Matin ou Après-midi)</h1>';
		}

		if(isset($_POST["date"]) AND empty($_POST["date"])
		AND $flag == 1)
		{
			echo '<h1 class="red">Veuillez choisir une date de réservation !</h1>';
		}
	}
	echo '
			</body>
		</html>
	';
?>
