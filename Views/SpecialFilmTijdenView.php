<?php

class SpecialFilmTijdenView {

    var $specal;
    var $datums = array();
    
    public function SpecialFilmTijdenView() {
        require_once('Helpers/DateHelper.php');
        require_once('Helpers/ArrayGrouper.php');
        require_once('backend/DBFunctions.php');
        
//        require_once('/Helpers/DateHelper.php');
//        require_once('/Helpers/ArrayGrouper.php');
//        require_once('/backend/DBFunctions.php');
    }

    public function Render($specialID) {
        
        //ducks in a row
         $dbfunctions = new DBFunctions();
         $this->specal = $dbfunctions->HaalSpecialOp($specialID);
        
        //haal voortstellingen op uit de DB
       
        $voorstellingen = $dbfunctions->VoorstellingenVoorSpecial($specialID);
        
        //check of we voorstellingen terug hebben gekregen.
        if (count($voorstellingen) == 0) {
            echo ("<div id=\"MeldingDiv\" class=\"GeenFilmsGevonden\">Er zijn geen voorstellingen gevonden voor dezer special.</div>");
        }
        else
        {
        //lus door de datum groepen heen en maak div aan.
        echo ("
                <table class=\"timeHeaderTable\">
                <tr class=\"dateRow\">
                    <th id=\"dateTh\">".$this->specal['Naam']." - ".DateHelper::VertaalDatumNaarVandaagMorgenOvermorgen($voorstellingen[0]['VoorstellingDatum'])."
                    </th>
                  </tr>  
                </table>
                ");

                //Groepeer deze op datum
        $datumGroepen = array_slice(ArrayGrouper::GroupArray($voorstellingen, 'VoorstellingDatum'), 0 , 1);

        foreach ($datumGroepen as $datum) {
            $display = "none;";
            $vertaaldeDatum = DateHelper::VertaalDatumNaarVandaagMorgenOvermorgen($datum['KeyItem']);
            $this->datums[$vertaaldeDatum] = $vertaaldeDatum;
            if (array_search($datum, array_keys($datumGroepen)) == 0) {
                $display = "block;";
            }

            echo ("    
                <div id =\"" . $vertaaldeDatum . "films\" style=\"display:" . $display . "\">
                <table class=\"timeTable\">    
                ");

            //groupeer de fims op titel
            $films = ArrayGrouper::GroupArray($datum['items'], "FilmNaam");

            //lus door de films
            foreach ($films as $film) {

                echo ("  

                        <tr>
                        <th><a href=\"films.php?filmid=" . $film['items'][0]['FilmID'] . "\">
                        " . $film['KeyItem'] . "</a>
                        </th>
                        <td class=\"timeClass\">

                        ");
                //lus door de voortstellingen
                foreach ($film['items'] as $voorstelling) {
                    $knopclass = "";
                    $reserveren = 0;
                    $filmTijd = strtotime($voorstelling['VoorstellingDatum'] . " " . $voorstelling['VoorstellingTijd']);
                    $morgen = DateHelper::Plus24uur();

                    if ($filmTijd > $morgen) {
                        $reserveren = 1;
                    }

                    if (intval($voorstelling['BeschikbareStoelen']) == 0) {
                        $knopclass = "uitverkocht";
                    }

                    echo ("
                                <button id=\"timeb\" class=\"" . $knopclass . "\" onClick=\"TijdKlik(" . $voorstelling['VoorstellingID'] . ", this, " . $reserveren . "," . $voorstelling['BeschikbareStoelen'] . ");\">" . substr($voorstelling['VoorstellingTijd'], 0, 5) . "</button>
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

}

?>
