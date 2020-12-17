<?php
	require_once("./class/c_affichage.php");
	require_once("./class/c_bdd.php");

	session_start();

	$MyBDD = new c_bdd("vehicule","users","localhost","root","");

	$MyAffichage = new c_affichage();
?>
