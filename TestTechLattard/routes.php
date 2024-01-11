<?php
    declare (strict_types=1);

    require_once(__DIR__."/serveur/country/controleurCountry.php");

    if (isset($_POST['route'])) {
        switch($_POST['route']){
            case "country" :
                $instanceCtrl = ControleurCountry::getControleurCountry();
                echo $instanceCtrl->Ctrl_Country_Actions($_POST['action']);
            break;
            default:
                echo "Route non valide";
            break;
        }
    } else {
        echo "Route non définie dans la requête POST";
    }
?>