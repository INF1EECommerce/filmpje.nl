<?php
class FilmpjeIdeal
{

 var $amount;
 var $orderId;
 var $issuer;
 var $description;
 var $reference;
    
public function ParseReservernPostValues($postvalues)
{
        try
        {
        
        $this -> amount = intval($postvalues['amount']) * 100;
        $this ->orderId = $postvalues['reference'];
        $this ->issuer = $postvalues['issuer'];
        $this ->description = $postvalues['description'];
        $this ->reference = $postvalues['reference'];
        return true;
        }
        catch(Exception $ex)
        {
            return FALSE;
        }

}
    
public function GenereerOrderEnGeefUrl() 
{

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
                ->setAmount($this->amount)
                ->setCountry("NL")
                ->setLanguage("NL")
                ->setReference($this->reference)
                ->setDescription($this->description)
                ->setCurrency("EUR")
                ->setIssuer($issuers[$this->issuer])
                ->setOrderID($this->orderId);
    
    // Merchant Settings
    $basicmode = Icepay_Basicmode::getInstance();
    $basicmode->setMerchantID(MERCHANTID)
            ->setSecretCode(SECRETCODE)
            ->setProtocol('http')
            //->useWebservice() // <--- Want to make a call using the webservices? You can using by using this method
            ->validatePayment($paymentObj); // <--- Required!

    return $basicmode->getURL();
    
}
}

?>
