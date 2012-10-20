<?php
class VandaagMorgenOvermorgenView
{

    public function VandaagMorgenOvermorgenView()
    {
        require_once('Helpers/DateHelper.php');
        require_once('Helpers/ArrayGrouper.php');
        require_once('backend/DBFunctions.php');
        
//        require_once('/Helpers/DateHelper.php');
//        require_once('/Helpers/ArrayGrouper.php');
//        require_once('/backend/DBFunctions.php');
    }
    
    var $datums = array();
    
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
                $display = "none;";
                $vertaaldeDatum = DateHelper::VertaalDatumNaarVandaagMorgenOvermorgen($datum['KeyItem']);
                $this->datums[$vertaaldeDatum] = $vertaaldeDatum;
                if ($vertaaldeDatum == "Vandaag") { $display = "block;"; }

                echo ("    
                <div id =\"" . $vertaaldeDatum . "films\" style=\"display:". $display ."\">
                <table class=\"timeTable\">    
                ");
                
                //groupeer de fims op titel
                $films = ArrayGrouper::GroupArray($datum['items'], "FilmNaam");

                        //lus door de films
                        foreach ($films as $film) { 

                        echo ("  

                        <tr>
                        <th><a href=\"films.php?filmid=".$film['items'][0]['FilmID']."\">
                        " . $film['KeyItem'] . "</a>
                        </th>
                        <td class=\"timeClass\">

                        ");
                                //lus door de voortstellingen
                                foreach ($film['items'] as $voorstelling) {
                                $knopclass = "";
                                $reserveren = 0;
                                $filmTijd = strtotime($voorstelling['VoorstellingDatum'] . " ". $voorstelling['VoorstellingTijd']);
                                $morgen = DateHelper::Plus24uur();
                               
                                if ($filmTijd > $morgen) {
                                $reserveren = 1;
                                }
                                
                                if (intval($voorstelling['BeschikbareStoelen']) == 0) {
                                 $knopclass = "uitverkocht";   
                                }
                                    
                                echo ("
                                <button id=\"timeb-".$voorstelling['VoorstellingID']."\" class=\"". $knopclass ."\" onClick=\"TijdKlik(". $voorstelling['VoorstellingID'] .", this, ".$reserveren.",".$voorstelling['BeschikbareStoelen'].");\">" . substr($voorstelling['VoorstellingTijd'], 0, 5). "</button>
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
                if (!isset($this->datums['Vandaag'])) {
                    echo ("<div id=\"Vandaagfilms\" class=\"GeenFilmsGevonden\">Er zijn geen voorstellingen gevonden voor deze datum.</div>");
                }  
                if (!isset($this->datums['Morgen'])) {
                    echo ("<div id=\"Morgenfilms\" class=\"GeenFilmsGevonden\" style=\"display: none;\">Er zijn geen voorstellingen gevonden voor deze datum.</div>");
                }  
                if (!isset($this->datums['Overmorgen'])) {
                    echo ("<div id=\"Overmorgenfilms\" style=\"display: none;\" class=\"GeenFilmsGevonden\">Er zijn geen voorstellingen gevonden voor deze datum.</div>");
                }  
    }
}
?>
