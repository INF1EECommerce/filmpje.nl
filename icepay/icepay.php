<?php
class FilmpjeIdeal
{
    
public function GenereerOrderEnGeefUrl(Bestelling $bestelling) 
{

try {
    
define('MERCHANTID',17164);//<--- Change this into your own merchant ID
define('SECRETCODE',"Ty84RqXj79BtNa65Awf3J4Qxr7E8Scs5GDb93Ygm");//<--- Change this into your own merchant ID

require_once 'icepay_api_basic.php';


// Read paymentmethods from folder and ensures the classes are included
$api = Icepay_Api_Basic::getInstance()->readFolder(realpath('../api/paymentmethods'));

// Store all paymentmethods in an array, as an example for loading programmatically
$paymentmethods = $api->getArray();

// Start a new paymentmethod class
$ideal = new $paymentmethods["ideal"](); //The same as: $ideal = new Icepay_Paymentmethod_Ideal();

// Retrieve the paymentmethod issuers for this example
$issuers = $ideal->getSupportedIssuers();


    /* Set the payment */
    $paymentObj = new Icepay_PaymentObject();
    $paymentObj->setPaymentMethod($ideal->getCode())
                ->setAmount($bestelling->totaalPrijs * 100)
                ->setCountry("NL")
                ->setLanguage("NL")
                ->setReference($bestelling->kenmerk)
                ->setDescription("Uw bestelling bij Filmpje.nl")
                ->setCurrency("EUR")
                ->setIssuer($issuers[$bestelling->banknummer])
                ->setOrderID($bestelling->kenmerk);
    // Merchant Settings
    $basicmode = Icepay_Basicmode::getInstance();
    $basicmode->setMerchantID(MERCHANTID)
            ->setSecretCode(SECRETCODE)
            ->setProtocol('http')
            //->useWebservice() // <--- Want to make a call using the webservices? You can using by using this method
            ->validatePayment($paymentObj); // <--- Required!
    $basicmode->setSuccessURL("http://chivan.com/filmpje.nl/bedankt.php?voorstelling=".$bestelling->voorstellingID."&modus=bestellen&referentie=".$bestelling->kenmerk);
    $basicmode->setErrorURL("http://chivan.com/filmpje.nl/betaalerror.php");
    return $basicmode->getURL();
}
 catch (Exception $ex)
 {
     throw new Exception("Er is een probleem opgetreden bij het communiceren met de betalingserver.");
 }
    
}
}

?>
