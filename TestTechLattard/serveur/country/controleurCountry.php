<?php
	require_once("includes/Country.inc.php");
	require_once("daoCountry.php");

	class ControleurCountry { 

		// Construction Controleur:

		static private $instanceCtrl = null;
	
		private function __construct(){}

		static function getControleurCountry():ControleurCountry{
			if(self::$instanceCtrl == null){
				self::$instanceCtrl = new ControleurCountry();  
			}
			return self::$instanceCtrl;
		}

		// Repartiteur d'actions:

		function Ctrl_Country_Actions($action){
			
			switch($action){
				case "remplirBd" :
					return $this->Ctrl_Country_Remplir_Bd();
				break;
                case "afficherCountries" :
					return $this->Ctrl_Country_Afficher_Countries();
				break;
			}
	    }

		// CRUD:
		// Create:

		function Ctrl_Country_Remplir_Bd(){
			DaoCountry::getDaoCountry()->Dao_Country_Remplir_Bd(); 
	    }

		// Read:

		function Ctrl_Country_Afficher_Countries(){
			
			return DaoCountry::getDaoCountry()->Dao_Country_Afficher_Countries(); 
	    }

		// // Update:

		// function Ctrl_Article_Form_Modifier($articleIda){
		// 	return DaoArticle::getDaoArticle()->Dao_Article_Form_Modifier($articleIda); 
		// }

		// function Ctrl_Article_Modifier($articleIda){
		// 	$nom = $_POST['nomArticle'];
		// 	$description = $_POST['description'];
		// 	$categorie = $_POST['categorie'];
		// 	$prix = $_POST['prix'];
		// 	$etat = $_POST['etat'];
		// 	$statut = $_POST['statut'];

		// 	$article = new Article($articleIda, $nom, $description, $categorie, $prix, $etat, ' ', $statut);
		// 	return DaoArticle::getDaoArticle()->Dao_Article_Modifier($article); 
		// }

		// function Ctrl_Article_Form_Changer_Statut($articleIda){
		// 	return DaoArticle::getDaoArticle()->Dao_Article_Form_Changer_Statut($articleIda); 
		// }

		// function Ctrl_Article_Changer_Statut($articleIda){
		// 	return DaoArticle::getDaoArticle()->Dao_Article_Changer_Statut($articleIda); 
		// }

		// // Delete

		// function Ctrl_Article_Form_Supprimer($articleIda){
		// 	return DaoArticle::getDaoArticle()->Dao_Article_Form_Supprimer($articleIda); 
		// }

		// function Ctrl_Article_Supprimer($articleIda){
		// 	return DaoArticle::getDaoArticle()->Dao_Article_Supprimer($articleIda); 
		// }
	}
?>