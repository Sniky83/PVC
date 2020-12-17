<?php
	require_once("./inc/structureBase.php");

	$MyAffichage->afficherHeadHTML("Connexion");

	$MyAffichage->afficherStructure(0,'',1);

	$MyAffichage->afficherFormulaireConnexion();

	$flag = 1;

	if(isset($_POST["username"]) AND !empty($_POST["username"])
	AND isset($_POST["password"]) AND !empty($_POST["password"])
	)
	{
		$etat = $MyBDD->authentifier($_POST["username"],$_POST["password"]);

		if($etat > 0)
		{
			$user = $_POST["username"];

			$_SESSION['log'] = $user;
			$_SESSION['id_equipe'] = $etat;

			header('Location: ./index.php');
		}
		if($etat == -1)
		{
			echo '<h1 class="red">Mot de passe ou nom d\'utilisateur incorrect !</h1>';
		}
		if($etat == -2)
		{
			echo '<h1 class="red">Problème de base donnée</h1>';
		}
	}
	else
	{
		if(empty($_POST["password"]) && isset($_POST["password"])
		&& empty($_POST["username"]) && isset($_POST["username"])
		)
		{
			echo '<h1 class="red">Veuillez entrer un mot de passe et un nom d\'utilisateur !</h1>';
			$flag = 0;
		}

		if(empty($_POST["password"]) && isset($_POST["password"])
		&& $flag == 1
		)
		{
			echo '<h1 class="red">Veuillez entrer un mot de passe !</h1>';
		}

		if(empty($_POST["username"]) && isset($_POST["username"])
		&& $flag == 1
		)
		{
			echo '<h1 class="red">Veuillez entrer un utilisateur !</h1>';
		}
	}

	if(isset($_SESSION['log']) && !empty($_SESSION['log']))
	{
		header('Location: ./index.php'); //Si on arrive a se connecter, alors on redirige sur l'index
	}
	echo '
					</div>
				</div>
			</body>
		</html>
	';
?>
