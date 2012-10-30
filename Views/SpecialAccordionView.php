<?php

class SpecialAccordionView {
    
    var $specials;
    
    public function SpecialAccordionView()
    {
        include_once 'backend/DBFunctions.php';
    }
    
    public function Render()
    {
    $dbFunctions = new DBFunctions();
    $this->specials = $dbFunctions->HaalSpecialsOp();
     
    echo ("
    <div id=\"SpecialAccordion\">
        "); 
    
    foreach ($this->specials as $special) {
    echo ("
    <h3>".$special['Naam']."</h3>
    <div>
    <a href=\"specials.php?SpecialID=".$special['SpecialID']."\">
    <img src=\"image/Specials/Banners/".$special['BlockImage']."\" alt=\"".$special['Naam']."\"></a>
        <p>
        ".$special['Beschrijving']."
        </p>
    </div>
    ");
    }
    echo ("
        </div>
    ");
    }
    
    
}

?>
