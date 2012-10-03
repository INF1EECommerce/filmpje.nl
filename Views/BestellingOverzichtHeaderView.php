<?php

class BestellingOverzichtHeaderView {

    var $totaalPrijs;

    public function BestellingOverzichtHeaderView() {
        require_once('/var/www/filmpje.nl/backend/DBFunctions.php');
        //require_once('/backend/DBFunctions.php');
        $this->totaalPrijs = 0.00;
    }

    public function Render($voorstelling) {

        $dbfunctions = new DBFunctions();
        $filmInfo = $dbfunctions->FilmInfoVanVoorstelling($voorstelling);

        echo("
                <h2>" . $filmInfo['Naam'] ." - ". $filmInfo['Datum'] ." - ". substr($filmInfo['Tijd'], 0, 5) ." UUR</h2>
            ");
    }

}
?>
