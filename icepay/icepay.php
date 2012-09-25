<?php
class FilmpjeIdeal
{

    
public function ParseReservernPostValues($postvalues)
{
    $result = array (
        "amount" => $postvalues['amount'],
        "orderId" => $postvalues['orderId'],
        "issuer" => $postvalues['issuer'],
        "description" => $postvalues['description'],
        "reference" => $postvalues['reference']
    );
    
    return $result;
}
    
public function Pay($amount, $reference, $description, $issuer, $orderId) 
{

define('MERCHANTID',17164);//<--- Change this into your own merchant ID
define('SECRETCODE',"Ty84RqXj79BtNa65Awf3J4Qxr7E8Scs5GDb93Ygm");//<--- Change this into your own merchant ID

require_once 'icepay_api_basic.php';

/* Apply logging rules */
$logger = Icepay_Api_Logger::getInstance();
$logger->enableLogging()
        ->setLoggingLevel(Icepay_Api_Logger::LEVEL_ALL)
        ->logToFile()
        ->setLoggingDirectory(realpath("../logs"))
        ->setLoggingFile("idealsample.txt")
        ->logToScreen();

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
                ->setAmount($amount)
                ->setCountry("NL")
                ->setLanguage("NL")
                ->setReference($reference)
                ->setDescription($description)
                ->setCurrency("EUR")
                ->setIssuer($issuers[$issuer])
                ->setOrderID($orderId);
    
    // Merchant Settings
    $basicmode = Icepay_Basicmode::getInstance();
    $basicmode->setMerchantID(MERCHANTID)
            ->setSecretCode(SECRETCODE)
            ->setProtocol('http')
            //->useWebservice() // <--- Want to make a call using the webservices? You can using by using this method
            ->validatePayment($paymentObj); // <--- Required!

    // In this testscript we're printing the url on screen.
    return $basicmode->getURL();
    
}
}

?>
