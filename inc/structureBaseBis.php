<?php
	if(isset($_SESSION['log']) && !empty($_SESSION['log']))
	{
		$user = $_SESSION['log'];
		$status = $MyBDD->getStatus($user);
		$resultat = $MyBDD->requeteAfficherReservation($user);

		if(isset($_SESSION['id_equipe']) && !empty($_SESSION['id_equipe']))
		{
			$id_equipe = $_SESSION['id_equipe'];
			$res = $MyBDD->checkReservationBDD($id_equipe);
		}

		if($resultat) //si on est Admin et qu'on veut voir si on a réservé
		{
			$MyAffichage->afficherStructure($status,$resultat,$res); //on rentre les params pour afficher les infos de la réservation
		}
		else
		{
			$MyAffichage->afficherStructure($status,'',1); //sinon, on ne met rien car on est membre donc on peut pas réserver
		}
	}
	else
	{
		$MyAffichage->afficherStructure(0,'',1); //sinon, vu qu'on est pas loggé, (status = 0, pas de res, pas de status de res non plus)
	}
?>
