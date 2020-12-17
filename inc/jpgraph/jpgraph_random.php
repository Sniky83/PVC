<?php
// require_once("include_path_inc.php");

require_once("jpgraph.php");
require_once("jpgraph_bar.php");
require_once("jpgraph_line.php");

$valeurs[] = array(100);
$valeursM[] = array(100);

for ($i=0 ; $i<100 ; $i++)
$valeurs[] = pow(rand($i - $i/20, $i + $i/20), 2);

for ($i=100 ; $i>0 ; $i--)
$valeursM[] = pow(rand($i - $i/20, $i + $i/20), 2);

$largeur = 1200;
$hauteur = 500;

// Initialisation du graphique
$graphe = new Graph($largeur, $hauteur);
// Echelle lineaire ('linlin') 
$graphe->SetScale("linlin",0,"auto",0,100); // échelle

// Creation de courbes
$courbe = new LinePlot($valeurs);
$courbeM = new LinePlot($valeursM);
// Ajout des courbes au graphique
$graphe->add($courbe);
$graphe->add($courbeM);

// Ajout du titre du graphique
$graphe->title->set("Courbes");

// Affichage du graphique
$graphe->stroke();
?>