<?php
class FilmTijdenView
{

    public function FilmTijdenView()
    {
        require_once('Helpers/DateHelper.php');
        require_once('Helpers/ArrayGrouper.php');
        require_once('backend/DBFunctions.php');
        
//        require_once('/Helpers/DateHelper.php');
//        require_once('/Helpers/ArrayGrouper.php');
//        require_once('/backend/DBFunctions.php');
    }
    
    public function Render($film)
    {
       //ducks in a row
        //haal voortstellingen op uit de DB
        $dbfunctions = new DBFunctions();
        $voorstellingen = $dbfunctions ->VoorstellingenVoorFilm($film);
         
        if (count($voorstellingen) > 0) {

        //Groepeer deze op datum
        $datumGroepen = ArrayGrouper::GroupArray($voorstellingen, 'VoorstellingDatum');
        
        
        //lus door de datum groepen heen en maak div aan.
        
                
                

                echo ("    
                <table class=\"timeTable\">    
                ");

                        //lus door de datums
               foreach ($datumGroepen as $datum) {
               $vertaaldeDatum = DateHelper::VertaalDatumNaarVandaagMorgenOvermorgen($datum['KeyItem']);
                        echo ("  

                        <tr>
                        <th>
                        " . $vertaaldeDatum . "
                        </th>
                        <td class=\"timeClass\">

                        ");
                                //lus door de voortstellingen
                                foreach ($datum['items'] as $voorstelling) {
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
                                
                        //datum tr afsluiten
                        echo ("
                        </td>
                        </tr>
                        ");
                        }
                //datum div afsluiten
                echo ("
                </table>
                ");
        } else {
               echo ("    
                <table class=\"timeTable\"><tr><td><span style=\"margin-left: 10px;\">Er zijn geen voorstellingen gevonden.<span></td</tr></table>    
                ");
        }
                
                }        
    
}
?>
