<?php
class TemplateParser
{
    private function Render($templateData, $templateText)
   {
      foreach ($templateData as $key => $value) {
        
          if (!is_array($value)) {

        $templateText = str_replace('{{'.$key.'}}', $value, $templateText);
                      
          }  
    }
    return $templateText;
   }
   
   public function GetTemplateTextAndRender($templateNaam, $templateData)
   {
       try {
           
       $templateText = file_get_contents(dirname(__FILE__) . "/". $templateNaam . ".txt");
       
       return $this->Render($templateData, $templateText);
       
       }
       catch (Exception $ex)
       {
           throw new Exception("Het templatebestand kon niet worden gevonden. ".$templateNaam);
       }
   }

}
?>
