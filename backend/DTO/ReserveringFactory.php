<?php
class ReserveringFactory
{
  public function BuildReserveringWithNewStatus($postvalues)
  {
     include_once('backend/DTO/Reservering.php');
     include_once('backend/Reserveringen.php');
     
//     include_once('/backend/DTO/Bestelling.php');
//     include_once('/backend/Bestellingen.php');
//     
     $reserveringen= new Reserveringen();
     $reservering = new Reservering();
     
     $reservering->voorstellingID = $postvalues['voorstelling'];
     $reservering->voornaam = $postvalues['voornaam'];
     $reservering->achternaam = $postvalues['achternaam'];
     $reservering->adres = $postvalues['adres'];
     $reservering->email = $postvalues['email'];
     $reservering->telefoonnummer = $postvalues['telefoon'];
     $reservering->totaalPrijs = $postvalues['amount'];
     $reservering->kenmerk = $postvalues['reference'];
     $reservering->ReserveringStatus = $reserveringen->ReserveringStatusIDForStatus("Ingediend");
     $reservering->stoelen = $postvalues['stoelen'];
     $reservering->postcode = $postvalues['postcode'];
     $reservering->plaats = $postvalues['plaats'];
     
     return $reservering;
  }
}
?>
