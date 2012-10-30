<?php

class SpecialAccordionView {
    
    var $specials;
    
    public function SpecialAccordionView()
    {
        include_once 'backend/Specials.php';
    }
    
    public function Render()
    {
    $specials = new Specials();
    $this->specials = $specials->HaalSpecialsOp(TRUE);
     
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
