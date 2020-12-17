<?php
	require_once("./inc/graph.php");

	require_once("./inc/structureBase.php");

	$MyAffichage->afficherHeadHTML("Mesures");

	require_once("./inc/structureBaseBis.php");

	function array_to_csv_download($vehicule, $result)
	{
		$filename = $vehicule.".csv";
	  	header("Content-type: text/csv");
	  	header('Content-Disposition: attachment; filename="'.$filename.'";');
		
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

		$headers = array("Type de la Mesure", "Avant Droit", "Avant Gauche", "Arriere Droit", "Arriere Gauche");
	    $array =
	    array(
		   	array(
				"type" => $type,
		   		"avant droite" => $result[1]." KG", //AVD
		   		"avant gauche" => $result[0]." KG", //AVG
		   		"arriere droit" => $result[3]." KG", //ARD
		   		"arriere gauche" => $result[2]." KG", //ARG
		   	),
	   	);

	   	ob_end_clean();

	   	$f = fopen('php://output', 'w');

	    fputcsv($f, $headers);

	    foreach ($array as $line) {
	        fputcsv($f, $line);
	    }

	    fclose($f);

	    exit();
	}

	if($status < 1)
	{
		header('Location: ./index.php');
	}

	$models = $MyBDD->requeteAfficherModels($id_equipe);

	if(isset($_POST['vehicule']) && !empty($_POST['vehicule'])
	&& isset($_POST['affichage']) && !empty($_POST['affichage'])
	&& isset($_POST['typeMesure']) && !empty($_POST['typeMesure'])
	)
	{
		$nomAndId = explode(':', $_POST['vehicule']);

		$id_model = $nomAndId[0];

		$type_mesure = $_POST['typeMesure'];

		$resultat = $MyBDD->requeteAfficherMesures($id_model,$type_mesure);

		if($resultat == 0)
		{
			echo '<h1 class="red">Aucune pesée n\'a été effectuée sur ce type de mesures !</h1>';
		}

		if(isset($_POST['csv']))
		{
			array_to_csv_download($nomAndId[1],$resultat);
		}

		if(isset($_POST['affichage']) && $_POST['affichage'] == 'tableau' || $resultat == 0)
		{
			$MyAffichage->afficherMesures($models,$resultat,'','','','');
		}
		elseif(isset($_POST['affichage']) && $_POST['affichage'] == 'graphique')
		{
				if(isset($resultat) && !empty($resultat))
				{
					$avd = $resultat[1];
					$avg = $resultat[0];
					$ard = $resultat[3];
					$arg = $resultat[2];
					$MyAffichage->afficherMesures($models,$resultat,$avd,$avg,$ard,$arg);
				}
		}
	}
	else
	{
		$MyAffichage->afficherMesures($models,'','','','','');
	}
?>
