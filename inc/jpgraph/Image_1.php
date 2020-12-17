<?php
// inclusions
require("jpgraph.php");
require("jpgraph_line.php"); 
// creation du graphique
$graph = new Graph(300, 200);
// Spécifie l'échelle à utiliser pour les axes X et Y 
// (linéaire, logarithmique, etc.). Obligatoire
$graph->SetScale("intint");
// creation de l'objet courbe 1
$ydata = array(2, 6, 12, 6, 8, 1, 9, 13, 5, 7, 14);
$courbe1 = new LinePlot($ydata);
$courbe1->SetColor("red");
// creation de l'objet courbe 2
$ydata2 = array(8, 5, 4, 3, 1, 4, 8, 10, 11, 12, 12.5);
$courbe2 = new LinePlot($ydata2);
$courbe2->SetColor("blue"); // SetColor("#FF0000")
// Ajouter les objets au graphique
$graph->Add($courbe1);
$graph->Add($courbe2);
// Dessiner le graphique
$graph->Stroke(); // argument vide = envoi navigateur, chemin absolu = sauver
?>
