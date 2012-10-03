<?php
class Bestelling
{
    var $voorstellingID;
    var $totaalPrijs;
    var $BestellingStatus;
    var $voornaam;
    var $achternaam;
    var $adres;
    var $postcode;
    var $email;
    var $telefoonnummer;
    var $bank;
    var $banknummer;
    var $stoelen;
    var $kenmerk;
    var $plaats;
    var $url;
    
    public function Bestelling()
    {
        $this -> voorstellingID = 0;
        $this -> totaalPrijs = 0.00;
        $this -> BestellingStatus = 0;
        $this -> voornaam = "";
        $this -> achternaam = "";
        $this -> adres = "";
        $this -> postcode = "";
        $this -> email = "";
        $this -> telefoonnummer = "";
        $this -> bank = "";
        $this -> banknummer = 0;
        $this -> stoelen = "";
        $this -> kenmerk = "";
        $this-> plaats = "";
    }
}
?>
