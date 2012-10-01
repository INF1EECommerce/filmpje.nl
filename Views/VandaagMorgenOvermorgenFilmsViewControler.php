<?php
class VandaagMorgenOvermorgenFilmsViewControler
{

    public function VandaagMorgenOvermorgenFilmsViewControler()
    {
        require_once('/Helpers/DateHelper.php');
        require_once('/Helpers/ArrayGrouper.php');
        require_once('/Backend/DBFunctions.php');
    }
    
    public function Render()
    {
       //ducks in a row
        //haal voortstellingen op uit de DB
        $dbfunctions = new DBFunctions();
        $voorstellingen = $dbfunctions -> VoorstellingenKomendeXDagen(2); 
         
        
        //Groepeer deze op datum
        $datumGroepen = ArrayGrouper::GroupArray($voorstellingen, 'VoorstellingDatum');
        
        
        //lus door de datum groepen heen en maak div aan.
        
                foreach ($datumGroepen as $datum) {
                $visibility = "collapse";
                $vertaaldeDatum = DateHelper::VertaalDatumNaarVandaagMorgenOvermorgen($datum['KeyItem']);
                if ($vertaaldeDatum == "Vandaag") { $visibility = "visible"; }

                echo ("    
                <div id =\"" . $vertaaldeDatum . "films\" style=\"visibility:". $visibility ."\">
                <table class=\"timeTable\">    
                ");
                
                //groupeer de fims op titel
                $films = ArrayGrouper::GroupArray($datum['items'], "FilmNaam");

                        //lus door de films
                        foreach ($films as $film) { 

                        echo ("  

                        <tr>
                        <th>
                        " . $film['KeyItem'] . "
                        </th>
                        <td class=\"timeClass\">

                        ");
                                //lus door de voortstellingen
                                foreach ($film['items'] as $voorstelling) {

                                echo ("
                                <button onClick=\"TijdButtonCick(". $voorstelling['VoorstellingID'] .")\">" . substr($voorstelling['VoorstellingTijd'], 0, 5). "</button>
                                ");

                                }
                                
                        //film tr afsluiten
                        echo ("
                        </td>
                        </tr>
                        ");
                        }
                //datum div afsluiten
                echo ("
                </table>
                </div>
                ");
                }        
    }
}
?>
