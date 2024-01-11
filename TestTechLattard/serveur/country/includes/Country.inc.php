<?php

class Country {
    private $idCountry;
    private $name;
    private $capital;
    private $region;

    // Constructeur
    function __construct($idCountry, $name, $capital, $region) {
        $this->setIdCountry($idCountry);
        $this->setName($name);
        $this->setCapital($capital);
        $this->setRegion($region);
    }

    // Getters
    function getIdCountry() { return $this->idCountry; }
    function getName() { return $this->name; }
    function getCapital() { return $this->capital; }
    function getRegion() { return $this->region; }

    // Setters
    function setIdCountry($idCountry) { $this->idCountry = $idCountry; }
    function setName($name) { $this->name = $name; }
    function setCapital($capital) { $this->capital = $capital; }
    function setRegion($region) { $this->region = $region; }
}
?>
