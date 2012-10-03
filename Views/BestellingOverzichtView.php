<?php

class BestellingOverzichtView {

    var $totaalPrijs;

    public function BestellingOverzichtView() {
        require_once('/var/www/filmpje.nl/backend/DBFunctions.php');
        //require_once('/backend/DBFunctions.php');
        $this->totaalPrijs = 0.00;
    }

    public function Render($geselecteerdeStoelen) {

        $dbfunctions = new DBFunctions();
        $stoelInfo = $dbfunctions->StoelInfo($geselecteerdeStoelen);

        echo("
                <table>
                <caption>Ticketoverzicht</caption>
                <thead>
                <th>Rij</th><th>Stoel</th><th>Type</th><th>Prijs</th>
                </thead>
                <tbody>
                ");

        foreach ($stoelInfo as $stoel) {
            $this->totaalPrijs = $this->totaalPrijs + floatval($stoel['StoelPrijs']);
            echo ("
                    <tr><td>" . $stoel['RijNummer'] . "</td><td>" . $stoel['StoelNummer'] . "</td><td>" . $stoel['StoelType'] . "</td><td>&euro; " . number_format((float) floatval($stoel['StoelPrijs']), 2, ',', '') . "</td></tr>      
                   ");
        }
        echo ("        
               </tbody>
                <tfoot>
                    <tr><td>Totaal:</td><td></td><td></td><td>&euro; " . number_format((float)$this->totaalPrijs, 2, ',', '') . "</td></tr>
                </tfoot>
            </table>
            ");
    }

}
?>
