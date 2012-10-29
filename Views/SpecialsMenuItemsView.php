<?php

class SpecialsMenuItemsView {
   
    var $specials;
    
    public function SpecialsMenuItemsView()
    {
        require_once 'backend/DBFunctions.php';
        $dbFunctions =  new DBFunctions();
        $this->specials =  $dbFunctions->HaalSpecialsOp();
    }
    
    public function Render()
    {
        if (is_array($this->specials)) {
            
            echo ("<ul>");
            
            foreach ($this->specials as $special) {
                 echo ("<li><a href=\"specials.php?SpecialID=" . $special['SpecialID'] . "\">" . $special['Naam'] . "</a></li>");
            }
            
            echo("</ul>");
        }
    }
    
}

?>
