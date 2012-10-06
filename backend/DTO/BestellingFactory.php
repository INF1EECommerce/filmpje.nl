<?php
class BestellingFactory
{
  public function BuildBestellingWithNewStatus($postvalues)
  {
     include_once('backend/DTO/Bestelling.php');
     include_once('backend/Bestellingen.php');
     
//     include_once('/backend/DTO/Bestelling.php');
//     include_once('/backend/Bestellingen.php');
//     
     $bestellingen= new Bestellingen();
     $bestelling = new Bestelling();
     
     $bestelling->voorstellingID = $postvalues['voorstelling'];
     $bestelling->voornaam = $postvalues['voornaam'];
     $bestelling->achternaam = $postvalues['achternaam'];
     $bestelling->adres = $postvalues['adres'];
     $bestelling->email = $postvalues['email'];
     $bestelling->telefoonnummer = $postvalues['telefoon'];
     $bestelling->banknummer = $postvalues['issuer'];
     $bestelling->totaalPrijs = $postvalues['amount'];
     $bestelling->kenmerk = $postvalues['reference'];
     $bestelling->BestellingStatus = $bestellingen->BestellingStatusIDForStatus("New");
     $bestelling->stoelen = $postvalues['stoelen'];
     $bestelling->postcode = $postvalues['postcode'];
     $bestelling->plaats = $postvalues['plaats'];
     
     return $bestelling;
  }
}
?>
