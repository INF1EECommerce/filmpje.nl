<?php

class BestellingOverzichtView {

    public function BestellingOverzichtView() {
        //moet het volledige pad zijn omdat deze class wordt aangeroepen als onderdeel van een externe call.
        include_once('/var/www/filmpje.nl/backend/Stoelen.php');
        include_once('/var/www/filmpje.nl/backend/TotaalPrijsCalculatie.php');
    }

    public function Render($geselecteerdeStoelen) {

        $stoelen = new Stoelen();
        $stoelInfo = $stoelen->StoelInfo($geselecteerdeStoelen, TRUE);

        echo("
                <table>
                <caption>Ticketoverzicht</caption>
                <thead>
                <th>Rij</th><th>Stoel</th><th>Type</th><th>Prijs</th>
                </thead>
                <tbody>
                ");

        foreach ($stoelInfo as $stoel) {
            echo ("
                    <tr><td>" . $stoel['RijNummer'] . "</td><td>" . $stoel['StoelNummer'] . "</td><td>" . $stoel['StoelType'] . "</td><td>&euro; " . number_format((float) floatval($stoel['StoelPrijs']), 2, ',', '') . "</td></tr>      
                   ");
        }
        echo ("        
               </tbody>
                <tfoot>
                    <tr><td>Totaal:</td><td></td><td></td><td>&euro; " . number_format(TotaalPrijsCalculatie::Calculeer($geselecteerdeStoelen), 2, ',', '') . "</td></tr>
                </tfoot>
            </table>
            ");
    }

    public function RenderVoorEmail($geselecteerdeStoelen) {

        $stoelen = new Stoelen();
        $stoelInfo = $stoelen->StoelInfo($geselecteerdeStoelen, TRUE);

        echo("
                <table>
                <tr>
                <td align=\left\" width=\"50\"><strong>Rij</strong></td><td align=\left\" width=\"50\"><strong>Stoel</strong></td><td align=\left\" width=\"50\"><strong>Type</strong></td><td align=\left\" width=\"50\"><strong>Prijs</strong></td>
                </tr>
            ");

        foreach ($stoelInfo as $stoel) {
            echo ("
                    <tr><td>" . $stoel['RijNummer'] . "</td><td>" . $stoel['StoelNummer'] . "</td><td>" . $stoel['StoelType'] . "</td><td>&euro; " . number_format((float) floatval($stoel['StoelPrijs']), 2, ',', '') . "</td></tr>      
                   ");
        }
        echo ("        

                    <tr><td><strong>Totaal:</strong></td><td></td><td></td><td><strong>&euro; " . number_format(TotaalPrijsCalculatie::Calculeer($geselecteerdeStoelen), 2, ',', '') . "</strong></td></tr>
            </table>
            ");
    }

}

?>
