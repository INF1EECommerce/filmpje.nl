<?php
print_r($_POST);
/*  Define your ICEPAY Merchant ID and Secret code. The values below are sample values and will not work, Change them to your own merchant settings. */
define('MERCHANTID', 17164);//<--- Change this into your own merchant ID
define('SECRETCODE', "Ty84RqXj79BtNa65Awf3J4Qxr7E8Scs5GDb93Ygm");//<--- Change this into your own merchant ID

require_once '/var/www/filmpje.nl/icepay/icepay_api_basic.php';
require_once '/var/www/filmpje.nl/backend/Bestellingen.php';
require_once '/var/www/filmpje.nl/backend/Mail/SendEmail.php';
//require_once '/backend/Bestellingen.php';

/* Start the postback class */
$icepay = new Icepay_Postback();
$icepay->setMerchantID(MERCHANTID)
        ->setSecretCode(SECRETCODE);
        //->doIPCheck(); // We encourage to enable ip checking for your own security


$bestellingen = new Bestellingen();

    if($icepay->validate()){
        // In this example the ICEPAY OrderID is identical to the Order ID used in our project
        $status = $bestellingen->BestellingStatusVoorID($icepay->getOrderID());

        /* Only update the status if it's a new order (NEW)
         * or update the status if the statuscode allowes it.
         * In this example the project order status is an ICEPAY statuscode.
         */
        if ($status == "New" || $status="Open"){
            $bestellingen->SlaStatusOp($icepay->getStatus(), $icepay->getOrderID()); //Update the status of your order
            
            if ($icepay->getStatus() == "OK") {

            //stuur email met bevestiging
            $sendEmail = new SendEmail();
            $sendEmail->ZendEmailForSuccesBetaling($icepay->getOrderID());                
            }
            
        }
    } else die ("Unable to validate postback data");
?>
