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

    // function Dao_Article_Fiche($articleIda){
    //     $connexion = Connexion::getInstanceConnexion()->getConnexion();
    //     $requete = "SELECT * FROM articles WHERE ida=".$articleIda;
    //     try{
    //         $stmt = $connexion->prepare($requete);
    //         $stmt->execute();
    //         $this->reponse['OK'] = true;
    //         $this->reponse['msg'] = "";
    //         $this->reponse['action'] = "ficheArticle";
    //         $this->reponse['article'] = $stmt->fetch(PDO::FETCH_OBJ);
            
    //     }catch (Exception $e){
    //         $this->reponse['OK'] = false;
    //         $this->reponse['msg'] = "Problème pour obtenir les données des articles";
    //     }finally {
    //         unset($connexion);
    //         return json_encode($this->reponse);
    //     }
    // }

    // // Update:

	// function Dao_Article_Form_Modifier($articleIda):string {
    //     $connexion = Connexion::getInstanceConnexion()->getConnexion();
    //     $requete = "SELECT * FROM articles WHERE ida=".$articleIda;
        
    //     $this->reponse = [
    //         'OK' => false,
    //         'msg' => "",
    //         'action' => "",
    //         'article' => null,
    //     ];

    //     try{
    //         $stmt = $connexion->prepare($requete);
    //         $stmt->execute();
    //         $this->reponse['OK'] = true;
    //         $this->reponse['msg'] = "";
    //         $this->reponse['action'] = "formModifierArticle";
    //         $this->reponse['article'] = $stmt->fetch(PDO::FETCH_OBJ);
    //     }catch (Exception $e){
    //         $this->reponse['OK'] = false;
    //         $this->reponse['msg'] = "Problème pour obtenir les données des articles";
    //     }finally {
    //         unset($connexion);
    //         return json_encode($this->reponse);
    //     }
    // }

    // function Dao_Article_Modifier($article):string {

    //     $ida = $article->getIda();
    //     $nom = $article->getNom();
    //     $description = $article->getDescription();
    //     $categorie = $article->getCategorie();
    //     $prix = $article->getPrix();
    //     $etat = $article->getEtat();
    //     $statut = $article->getStatut();

    //     $connexion = Connexion::getInstanceConnexion()->getConnexion();
    //     $requete = "SELECT * FROM articles WHERE ida=".$ida;

    //     $this->reponse = [
    //         'OK' => false,
    //         'msg' => "",
    //         'action' => "",
    //         'article' => null,
    //     ];

    //     try{
	// 		$stmt = $connexion->prepare($requete);
    //         $stmt->execute();
			
    //         $anciennePhoto = $stmt->fetch(PDO::FETCH_OBJ)->photo;
    //         $photo = self::chargerPhotoArticleModifie($anciennePhoto);
			
	// 		$requete2 = "UPDATE articles SET nom=?, description=?, categorie=?, prix=?, etat=?, photo=?, statut=? WHERE ida=".$ida;
	// 		try{
    //             $donnees2 = [$nom, $description, $categorie, $prix, $etat, $photo, $statut];
    //             $stmt2 = $connexion->prepare($requete2);
    //             $stmt2->execute($donnees2);
    //             try{
    //                 $requete3 = "SELECT * FROM articles WHERE ida=".$ida;
    //                 $stmt3 = $connexion->prepare($requete3);
    //                 $stmt3->execute();
                    
    //                 $this->reponse['article'] = $stmt3->fetch(PDO::FETCH_OBJ);
    //                 $this->reponse['OK'] = true;
    //                 $this->reponse['msg'] = "";
    //                 $this->reponse['action'] = "envoyerModifArticle";
    //             }catch(Exception $e){
    //                 $this->reponse['OK'] = false;
    //                 $this->reponse['msg'] = "Problème requete3";
    //             }
    //         }catch(Exception $e){
    //             $this->reponse['OK'] = false;
    //             $this->reponse['msg'] = "Problème requete2";
    //         }         
	// 	}catch(Exception $e){
    //         $this->reponse['OK'] = false;
    //         $this->reponse['msg'] = "Problème requete1";
	// 	}finally{
	// 		unset($connexion);
    //         return json_encode($this->reponse);
	// 	}
    // }

    // function Dao_Article_Form_Changer_Statut($articleIda){
    //     $connexion = Connexion::getInstanceConnexion()->getConnexion();
    //     $requete = "SELECT * FROM articles WHERE ida = ".$articleIda;
    //     try{
    //         $stmt = $connexion->prepare($requete);
    //         $stmt->execute();
    //         $this->reponse['OK'] = true;
    //         $this->reponse['msg'] = "";
    //         $this->reponse['action'] = "formChangerStatutArticle";
    //         $this->reponse['article'] = $stmt->fetch(PDO::FETCH_OBJ);
    //     }catch (Exception $e){
    //         $this->reponse['requete'] = $requete;
    //         $this->reponse['OK'] = false;
    //         $this->reponse['msg'] = "Problème pour obtenir les données des articles";
    //     }finally {
    //         unset($connexion);

    //         return json_encode($this->reponse);
    //     }
    // }

    // function Dao_Article_Changer_Statut($articleIda):string {
    //     $connexion = Connexion::getInstanceConnexion()->getConnexion();
    //     $requete = "SELECT * FROM articles WHERE ida=".$articleIda;

    //     $this->reponse = [
    //         'OK' => false,
    //         'msg' => "debut",
    //         'action' => "",
    //         'statutArticle' => null,
    //     ];

    //     try{
    //         $stmt = $connexion->prepare($requete);
    //         $stmt->execute();
    //         $this->reponse['statutArticle'] = $stmt->fetch(PDO::FETCH_OBJ)->statut;

    //         switch($this->reponse['statutArticle']){
    //             case "A" :
    //                 $this->reponse['statutArticle'] = 'I';
    //             break;
    //             case "I" :
    //                 $this->reponse['statutArticle'] = 'A';
    //             break;
    //             }
    //         $requete2 = "UPDATE articles SET statut='".$this->reponse['statutArticle']."' WHERE ida=".$articleIda;
    //         try{
    //             $stmt2 = $connexion->prepare($requete2);
    //             $stmt2->execute();
    //             $requete3 = "SELECT * FROM articles WHERE ida = ".$articleIda;
    //             try{
    //                 $stmt3 = $connexion->prepare($requete3);
    //                 $stmt3->execute();
                    
    //                 $this->reponse['OK'] = true;
    //                 $this->reponse['msg'] = "c'est okay";
    //                 $this->reponse['article'] = $stmt3->fetch(PDO::FETCH_OBJ);
    //                 $this->reponse['action'] = "changerStatutArticle";
    //             }catch(Exception $e){
    //                 $this->reponse['OK'] = false;
    //                 $this->reponse['msg'] = "Problème requete3";
    //             }
    //         }catch(Exception $e){
    //             $this->reponse['OK'] = false;
    //             $this->reponse['msg'] = "Problème requete2";
    //         }         
    //     }catch(Exception $e){
    //         $this->reponse['OK'] = false;
    //         $this->reponse['msg'] = "Problème requete1";
    //     }finally{
    //         unset($connexion);
    //         return json_encode($this->reponse);
    //     }
    // }

    // // Delete:

    // function Dao_Article_Form_Supprimer($articleIda){
    //     $connexion = Connexion::getInstanceConnexion()->getConnexion();
    //     $requete = "SELECT * FROM articles WHERE ida=".$articleIda;
    //     try{
    //         $stmt = $connexion->prepare($requete);
    //         $stmt->execute();
    //         $this->reponse['OK'] = true;
    //         $this->reponse['msg'] = "";
    //         $this->reponse['action'] = "formSupprimerArticle";
    //         $this->reponse['article'] = $stmt->fetch(PDO::FETCH_OBJ);
    //     }catch (Exception $e){
    //         $this->reponse['OK'] = false;
    //         $this->reponse['msg'] = "Problème pour obtenir les données des articles";
    //     }finally {
    //         unset($connexion);

    //         return json_encode($this->reponse);
    //     }
    // }

    // function Dao_Article_Supprimer($articleIda):string {
    //     $connexion = Connexion::getInstanceConnexion()->getConnexion();
    //     $requete = "DELETE FROM articles WHERE ida=".$articleIda;
    //     try{
    //         $stmt = $connexion->prepare($requete);
    //         $stmt->execute();
    //         $this->reponse['OK'] = true;
    //         $this->reponse['msg'] = "Article bien supprimé";
    //     }catch (Exception $e){
    //         $this->reponse['OK'] = false;
    //         $this->reponse['msg'] = "Probème lors de la suppression de l'article";
    //     }finally {
    //         unset($connexion);
    //         return json_encode($this->reponse);
    //     }
    // }

}

?>