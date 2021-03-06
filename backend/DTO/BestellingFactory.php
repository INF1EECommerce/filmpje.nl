<?php
class BestellingFactory
{
  public function BuildBestellingWithNewStatus($postvalues)
  {
     include_once('backend/DTO/Bestelling.php');
     include_once('backend/Bestellingen.php');
     include_once 'backend/TotaalPrijsCalculatie.php';
     
     $bestellingen= new Bestellingen();
     $bestelling = new Bestelling();
     
     $bestelling->voorstellingID = $postvalues['voorstelling'];
     $bestelling->voornaam = $postvalues['voornaam'];
     $bestelling->achternaam = $postvalues['achternaam'];
     $bestelling->adres = $postvalues['adres'];
     $bestelling->email = $postvalues['email'];
     $bestelling->telefoonnummer = $postvalues['telefoon'];
     $bestelling->banknummer = $postvalues['issuer'];
     $bestelling->totaalPrijs = TotaalPrijsCalculatie::Calculeer($postvalues['geselecteerdestoelen']);
     $bestelling->kenmerk = $postvalues['reference'];
     $bestelling->BestellingStatus = $bestellingen->BestellingStatusIDForStatus("New", TRUE);
     $bestelling->stoelen = $postvalues['geselecteerdestoelen'];
     $bestelling->postcode = $postvalues['postcode'];
     $bestelling->plaats = $postvalues['plaats'];
     
     return $bestelling;
  }
}
?>
