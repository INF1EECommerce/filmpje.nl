<?php

class ZoekresultatenView {

    var $films;
    var $resultaten;
    var $singles = array();
    var $dupes = array();
    var $matchTypes = array();
    var $count = 1;
    var $rowcount = 1;

    public function ZoekresultatenView($query) {
        $this->films = new Films();
        $this->resultaten = $this->films->ZoekenNaarFilms($query, TRUE);

        foreach ($this->resultaten as $film) {
            if (!in_array($film['Naam'], $this->dupes)) {
                $this->singles[] = $film;
                $this->dupes[] = $film['Naam'];
                $this->matchTypes[] = $film['Naam'];
                $this->matchTypes[$film['Naam']] = array();
                $this->matchTypes[$film['Naam']][] = $film['MatchType'];
            } else {
                $this->matchTypes[$film['Naam']][] = $film['MatchType'];
            }
        }
    }

    public function Render() {

        if (count($this->singles) == 0) {
            echo "<div class=\"GeenFilmsGevonden\">Er zijn geen films gevonden die aan uw zoekcriteria voldoen.</div>";
        } else {
            echo ("  
        <div id=\"ZoekResultatenRows\">");
            foreach ($this->singles as $film) {
                $kijwijzericonen = explode(",", $film['Kijkwijzer']);
                $kijkwijzerhtml = "";

                foreach ($kijwijzericonen as $icon) {
                    $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/" . $icon . ".png\"/>";
                }
                echo ("
                    <div class=\"posterRow\" >
                        <div id=\"" . $film['FilmID'] . "\" class=\"filmoverzichtposterrowview\">
                            <h2 class=\"subblockheader\" style=\"margin-bottom: 0px;\">" . $film['Naam'] . "</h2>
                            <a href=\"films.php?filmid=" . $film['FilmID'] . "\"><img class=\"filoverzichtcoverrowview\" src=\"image/Covers/" . $film['Cover'] . "\"></a>
                            <strong>Genre: </strong>" . $film['Genre'] . "
                            <br><strong>Regisseur: </strong>" . $film['Regisseur'] . "<br>
                            <strong>IMDB: </strong>" . $film['Beoordeling'] . "    
                            <br><br>
                            <strong>Gevonden op: </strong> " . implode(", ", $this->matchTypes[$film['Naam']]) . "
                            <br><br>
                            " . $kijkwijzerhtml . "
                            <br><br>
                            <div class=\"filmoverzichtbeschrijving\">" . $film['Beschrijving'] . "</div>
                        </div>
                    </div>");
            }
            echo ("</div>");
        }
    }

}

?>
