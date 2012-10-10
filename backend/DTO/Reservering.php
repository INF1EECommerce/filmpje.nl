<?php
class Reservering
{
    var $voorstellingID;
    var $totaalPrijs;
    var $ReserveringStatus;
    var $voornaam;
    var $achternaam;
    var $adres;
    var $postcode;
    var $email;
    var $telefoonnummer;
    var $banknummer;
    var $stoelen;
    var $kenmerk;
    var $plaats;
    var $url;
    
    public function Reservering()
    {
        $this -> voorstellingID = 0;
        $this -> totaalPrijs = 0.00;
        $this -> ReserveringStatus = 0;
        $this -> voornaam = "";
        $this -> achternaam = "";
        $this -> adres = "";
        $this -> postcode = "";
        $this -> email = "";
        $this -> telefoonnummer = "";
        $this -> banknummer = 0;
        $this -> stoelen = "";
        $this -> kenmerk = "";
        $this-> plaats = "";
    }
}
?>
