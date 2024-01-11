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
	}
?>