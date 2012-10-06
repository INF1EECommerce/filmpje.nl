<?php

class SendEmail
{
    public function SendEmail()
    {
        include_once '/var/www/filmpje.nl/backend/Mail/Templates/TemplateParser.php';
        include_once '/var/www/filmpje.nl/backend/Bestellingen.php';
        include_once '/var/www/filmpje.nl/Views/BestellingOverzichtView.php';
    }
    
    
    public function ZendEmailForSuccesBetaling($kenmerk)
    {
        $bestellingen = new Bestellingen();
        $data = $bestellingen->HaalBestellingOp($kenmerk);
        $emailTo = $data[0]['Email'];
        $bov = new BestellingOverzichtView();
        $stoelen = array();
        
         foreach ($data as $stoel) {
            $stoelen[] = $stoel['StoelID'];

        }
        
        $stoelenImploded =  implode(",", $stoelen);
        
         ob_start();
         $bov->RenderVoorEmail($stoelenImploded);
         $stoelenTabel = ob_get_contents();
         ob_end_clean();

        
        
        $templateData = array(
          
            "achternaam" => $data[0]['Achternaam'],
            "kenmerk" => $data[0]['Kenmerk'],
            "filmnaam" => $data[0]['FilmNaam'],
            "datum" => $data[0]['VoorstellingDatum'],
            "tijd" => substr($data[0]['VoorstellingTijd'], 0, 5),
            "zaalnummer" => $data[0]['ZaalNaam'],
            "voornaam" => $data[0]['Voornaam'],
            "adres" => $data[0]['Adres'],
            "postcode" => $data[0]['Postcode'],
            "plaats" => $data[0]['Plaats'],
            "email" => $data[0]['Email'],
            "telefoon" => $data[0]['Telefoonnummer'],
            "stoelen" => $stoelenTabel
        );
        
       
        
        $this->SendTemplatedEmailBestelling($emailTo, 'Bestelling', "Uw bestelling bij Filmpje", $templateData);
        $this->SendTemplatedEmailBestelling("chivan@chivan.com", 'BestellingBioscoop', "Bestelling op Filmpje.nl", $templateData);
        
    }
    
    public function SendTemplatedEmailBestelling($to, $template, $subject, $templateData )
    {
        if (!isset($to) || !isset($template) || !isset($templateData) || !isset($subject)) {
            throw new Exception('Een van de parameters is leeg');
        }
        
        $templateParser = new TemplateParser();
        $textEmail = $templateParser->GetTemplateTextAndRender($template ."TextTemplate", $templateData);
        $htmlEmail = $templateParser->GetTemplateTextAndRender($template ."HTMLTemplate", $templateData);
        
        //specify the email address you are sending to, and the email subject
        $email = $to;

        //create a boundary for the email. This 
        $boundary = uniqid('np');

        //headers - specify your from email address and name here
        //and specify the boundary for the email
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "From: Filmpje.nl <no-reply@filmpje.nl> \r\n";
        $headers .= "To: ".$email."\r\n";
        $headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";

        //here is the content body
        $message = "This is a MIME encoded message.";
        $message .= "\r\n\r\n--" . $boundary . "\r\n";
        $message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";

        //Plain text body
        $message .= $textEmail;
        $message .= "\r\n\r\n--" . $boundary . "\r\n";
        $message .= "Content-type: text/html;charset=utf-8\r\n\r\n";

        //Html body
        $message .= $htmlEmail;
        $message .= "\r\n\r\n--" . $boundary . "--";

        //invoke the PHP mail function
        mail('', $subject, $message, $headers);

    }
}
?>
