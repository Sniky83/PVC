<?php
		if(isset($_GET['f']) && $_GET['f'] == 'afficherGraph'
		&& isset($_GET['voiture']) && isset($_GET['type'])
		&& isset($_GET['avd']) && isset($_GET['avg'])
		&& isset($_GET['ard']) && isset($_GET['arg'])
		)
		{
      		afficherGraph($_GET['voiture'],$_GET['type'],$_GET['avd'],$_GET['avg'],$_GET['ard'],$_GET['arg']);
		}

		function afficherGraph($voiture,$type,$avd,$avg,$ard,$arg)
		{
			require('../inc/jpgraph/jpgraph.php');
			require('../inc/jpgraph/jpgraph_pie.php'); // camembert
			require('../inc/jpgraph/jpgraph_pie3d.php'); // camembert 3D
			// creation du graphique
			$graph = new PieGraph(500, 250);
			$graph->SetShadow();
			$graph->title->Set("Mesures sur la $voiture $type");
			// creation objet camembert
			$data = array($avd, $avg, $ard, $arg);
			$legend = array('Avant Droit', 'Avant Gauche', 'Arrière Droit', 'Arrière Gauche');
			$camembert = new PiePlot3D($data);
			$camembert->SetAngle(45); // angle de projection (10 a 85 degres)
			$camembert->SetSize(0.5); // entre 0 et 0.5
			$camembert->SetCenter(0.4); // on peut definir x et y
			$camembert->SetLegends($legend);
			$camembert->SetTheme('water'); // earth, water, pastel, sand
			// ajout du camembert au graphe
			$graph->Add($camembert);
			// envoi
			$graph->img->SetImgFormat("png");
			$graph->Stroke();
		}
?>
