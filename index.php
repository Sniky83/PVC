<?php
	require_once("./inc/structureBase.php");

	$MyAffichage->afficherHeadHTML("Accueil");

	require_once("./inc/structureBaseBis.php");

  if(isset($user))
  {
	 $idReservation = $MyBDD->getIdReservation($user);
  }

	if(isset($idReservation) && $idReservation != 0)
	{
		$MyBDD->deleteReservationAfter($idReservation);
	}

	if(isset($_SESSION['flash']))
	{
		$message = '<h1 class="green">Réservation validée !</h1>';

		unset($_SESSION['flash']);

		$MyAffichage->afficherIndex($message);
	}
	else
	{
		$MyAffichage->afficherIndex('');
	}


	echo '
			</body>
		</html>
	';
?>
