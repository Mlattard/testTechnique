<?php 

declare (strict_types=1);

// ini_set('allow_url_fopen', 1);

require_once(__DIR__."/../bd/connexion.inc.php");
require_once(__DIR__."/includes/Country.inc.php");

class DaoCountry {

    // Construction Dao:

    static private $instanceDaoCountry = null;
    
    private $reponse = array();
    private $connexion = null;
	
    private function __construct(){}
    
	static function getDaoCountry():DaoCountry {
		if(self::$instanceDaoCountry == null){
			self::$instanceDaoCountry = new DaoCountry();
		}
		return self::$instanceDaoCountry;
	}


    // CRUD:
    // Create:

    function Dao_Country_Remplir_Bd() {
        $connexion = Connexion::getInstanceConnexion()->getConnexion();
        
        // Vérifie si la table est vide ou si elle doit être remplie

        $requete = "SELECT * FROM countries";
        try{
            $stmt = $connexion->prepare($requete);
            $stmt->execute();

            $nombreDeLignes = $stmt->rowCount();
            
            if ($nombreDeLignes > 0) {
                $this->reponse['OK'] = true;
                $this->reponse['msg'] = "Bd lue avec succès";
                return;

            } else {
                $this->reponse['OK'] = false;
                $this->reponse['msg'] = "La table est vide.";
            }
            
        }catch (Exception $e){
            $this->reponse['OK'] = false;
            $this->reponse['msg'] = "Erreur lors de la lecture de la Bd : " . $e->getMessage();;
        }

        // S'execute seulement si la table est vide

        $api_url = "https://restcountries.com/v3.1/all";
        try{
            $data = file_get_contents($api_url);

            if (!$data) {
                throw new Exception("Erreur lors de la récupération des données de l'API.");
            }

            $countriesData = json_decode($data, true);

            foreach ($countriesData as $country) {
                if (isset($country['name']['common']) && isset($country['capital']) && isset($country['region'])) {
                    
                    $countryName = $country['name']['common'];
                    $capitalName = $country['capital'][0];
                    $regionName = $country['region'];

                    $requete = "INSERT INTO countries (name, capital, region) VALUES (?, ?, ?)";
                    try{
                        $donnees = [$countryName, $capitalName, $regionName];
                        $stmt = $connexion->prepare($requete);
                        $stmt->execute($donnees);
                        
                        $this->reponse['OK'] = true;
                        $this->reponse['msg'] = "Bd remplie avec succès";
                    }catch (Exception $e){
                        $this->reponse['OK'] = false;
                        $this->reponse['msg'] = "Erreur lors du remplissage de la Bd : " . $e->getMessage();;
                    }
                }
            }

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return array();
        }
    }

    // Read:

    function Dao_Country_Afficher_Countries():string {

        $connexion = Connexion::getInstanceConnexion()->getConnexion();
        $requete = "SELECT * FROM countries";
        try{
            $stmt = $connexion->prepare($requete);
            $stmt->execute();
            $this->reponse['OK'] = true;
            $this->reponse['msg'] = "";
            $this->reponse['action'] = "afficherCountries";
            $this->reponse['listeCountries'] = array();
            while($ligne = $stmt->fetch(PDO::FETCH_OBJ)){
                $this->reponse['listeCountries'][] = $ligne;
            }            
        }catch (Exception $e){
            $this->reponse['OK'] = false;
            $this->reponse['msg'] = "Problème pour obtenir les données des articles";
        }finally {
            unset($connexion);
            return json_encode($this->reponse);
        }
    }
}

?>