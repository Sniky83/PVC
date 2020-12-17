<?php
	class c_bdd{
		// Attributs
		private $BDD;
		private $Table;
		private $SQL_host;
		private $SQL_user;
		private $SQL_pass;

		// Methodes
		public function __construct($BDD, $table, $host, $user, $pass){
			$this->BDD = $BDD;
			$this->Table = $table;
			$this->SQL_host = $host;
			$this->SQL_user = $user;
			$this->SQL_pass = $pass;
		}

		public function authentifier($username, $password){
			$hashed_password = hash("sha256", $password);
			$requete = "SELECT * FROM `users` WHERE `username`='$username' AND `password`='$hashed_password'";
			$resultat = $this->effectuerRequete($requete);
			if($resultat)
			{
				$i = 0;
				while($tab = $resultat->fetch_row())
				{
					$i++;
					$id_equipe = $tab[1];
				}

				if($i > 0)
				{
					$etat = $id_equipe; // Auth OK = DUMP de l'id de l'equipe
				}
				else
				{
					$etat = -1;	// Erreur Auth
				}
			}
			else
			{
				$etat = -2;	// Autre erreur (SQL)
			}
			return $etat;
		}

		public function getStatus($username){
			$requete = "SELECT `status` FROM `users` WHERE `username`='$username'";
			$resultat = $this->effectuerRequete($requete);
			while($tab = $resultat->fetch_row())
			{
				$status = $tab[0];
			}
			return $status;
		}

		public function reserver($periode, $date, $id_equipe){
			$requete = "INSERT INTO `reservations` VALUES(NULL, '$id_equipe', '$periode', '$date')";
			$this->effectuerRequete($requete);
		}

		public function checkIfReservationExists($date,$periode){
			$requete = "SELECT COUNT(`date_reservation`)
						FROM `reservations`
						WHERE `date_reservation`='$date'
						AND `periode_journee`='$periode';";
			$resultat = $this->effectuerRequete($requete);
			while($row = $resultat->fetch_row())
			{
				$row[0];

				if($row[0] == 0)
				{
					$res = 1; //si la réservation est libre
				}
				else
				{
					$res = 0; //si il y'a deja une réservation
				}
			}
			return $res;
		}

		public function checkReservationBDD($id_equipe){
			$requete = "SELECT COUNT(`id_equipe`)
						FROM `reservations` r
						INNER JOIN `equipes` e
						ON `r`.`id_equipe`=`e`.`id`
						WHERE `e`.`id`='$id_equipe';";
			$resultat = $this->effectuerRequete($requete);
			while($row = $resultat->fetch_row())
			{
				$row[0];

				if($row[0] == 0)
				{
					$res = 1; //si on a pas réservé car le COUNT() = 0;
				}
				else
				{
					$res = 0; //si on a réservé
				}
			}
			return $res;
		}

		public function requeteAfficherModels($id_equipe){
			//INNER JOIN `mesures` me
			//ON `me`.`id_model`=`m`.`id`
			$requete = "SELECT *
						FROM `models` m
						INNER JOIN `equipes` e
						ON `e`.`id`=`m`.`id_equipe`
						WHERE `e`.`id`='$id_equipe';";
			$resultat = $this->effectuerRequete($requete);
			$i = 0;
			while($row = $resultat->fetch_row())
			{
				$res[$i][0] = $row[0]; //id
				$res[$i][1] = $row[2]; //nom model
				$i++;
			}
			return $res;
		}

		public function requeteAfficherMesures($id_model,$type_mesure){
			$requete = "SELECT `AV_G`,`AV_D`,`AR_G`,`AR_D`
						FROM `mesures` m
						INNER JOIN `models` mo
						ON `mo`.`id`=`m`.`id_model`
						WHERE `mo`.`id` = '$id_model'
						AND `m`.`type_mesure`= '$type_mesure';";
			$resultat = $this->effectuerRequete($requete);
			while($row = $resultat->fetch_row())
			{
				$res[0] = $row[0];
				$res[1] = $row[1];
				$res[2] = $row[2];
				$res[3] = $row[3];
			}
			if(!isset($res))
				return 0;
			else
				return $res;
		}

		public function requeteAfficherReservation($user){
			$requete = "SELECT `periode_journee`, `date_reservation`
						FROM `reservations` r
						INNER JOIN `users`
						ON `users`.`id_equipe`=`r`.`id_equipe`
						WHERE `users`.`username`='$user';";
			$resultat = $this->effectuerRequete($requete);
			if($resultat)
			{
				while($row = $resultat->fetch_assoc())
				{
					$message = "<b>Vous avez 1 réservation pour le ".$row['date_reservation'];
					if($row['periode_journee'] == 'AM')
					{
						$message .= " le matin</b>";
					}
					else
					{
						$message .= " l'après midi</b>";
					}
					if($row['periode_journee'] != NULL)
					{
						$drapal = 1;
					}
				}
			}
			if(isset($drapal) && $drapal == 1)
			{
				$drapal = 0;
				return $message;
			}
		}

		public function getIdReservation($nom){
			$requete = "SELECT *
						FROM `reservations` r
						INNER JOIN `equipes` e
						ON `e`.`id` = `r`.`id_equipe`
						WHERE `e`.`nom` = 'Renault';
						";
			$resultat = $this->effectuerRequete($requete);
			while($row = $resultat->fetch_row())
			{
				$message = $row[0];
			}
			if(!isset($message))
			{
				return 0;
			}
			else
			{
				return $message;
			}
		}

		public function deleteReservationAfter($id){
			$requete = "DELETE FROM `reservations`
						WHERE `id` = '$id'
						AND UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(date_reservation) > 0";
			$this->effectuerRequete($requete);
		}

		private function effectuerRequete($requete){
			$SQL_host = "localhost";
			$SQL_user = "root";
			$SQL_pass = "";
			$BDD = "vehicule";

			$connexion = new mysqli($this->SQL_host,$this->SQL_user,$this->SQL_pass,$this->BDD);
			$resultat = $connexion->query($requete);
			return $resultat;
		}
	}
?>
