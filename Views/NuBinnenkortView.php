<?php

class NuBinnenkortView {

    var $dbfunctions;
    var $films;
    var $filmgroups;
    var $count = 1;
    var $rowcount = 1;

    public function NuBinnenkortView() {
        include_once 'backend/DBFunctions.php';
        include_once 'Helpers/ArrayGrouper.php';
        $this->dbfunctions = new DBFunctions();
        $this->films = $this->dbfunctions->AlleFims();
        $this->filmgroups = ArrayGrouper::GroupArray($this->films, 'FilmType');
    }

    public function Render() {
        //tile modus divs
        echo ("
        <div id=\"Tiles\">
        <div id=\"NuFilms\">
        <div class=\"posterRow\">");
        //lus door de nu films heem
        if (!isset($this->filmgroups['Nu'])) { echo "<div class=\"GeenFilmsGevonden\">Er zijn geen films gevonden die aan de criteria voldoen.</div>"; }
        if (isset($this->filmgroups['Nu'])) {
        foreach ($this->filmgroups['Nu']['items'] as $film) {
            $kijwijzericonen = explode(",", $film['Kijkwijzer']);

            $kijkwijzerhtml = "";
            foreach ($kijwijzericonen as $icon) {
                $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/" . $icon . ".png\"/>";
            }
            echo ("
                    <div id=\"" . $film['FilmID'] . "\" class=\"filmoverzichtposter\">
                        <p>" . $film['KorteNaam'] . "</p>
                        <a href=\"films.php?filmid=" . $film['FilmID'] . "\"><img class=\"filoverzichtcover\" src=\"image/Covers/" . $film['Cover'] . "\"></a><br>
                        <strong>Genre</strong><br>" . $film['Genre'] . "<br>
                    " . $kijkwijzerhtml . "
                    </div>
                    ");

            if ($this->rowcount % 4 == 0 && $this->count != $this->filmgroups['Nu']['count']) {
                echo '</div><div class="posterRow">';
                $this->rowcount = 0;
            }
            if ($this->count == $this->filmgroups['Nu']['count']) {
                echo '</div>';
            }
            $this->count++;
            $this->rowcount++;
        }
        //nufilms div afsluiten           
        echo("</div>");
        }
        //binkort div openen
        //count waardes resetten voor nieuwe filmrijen.
        $this->count = 1;
        $this->rowcount = 1;
        echo ("
        <div id=\"BinnenkortFilms\"style=\"display:none;\">
            <div class=\"posterRow\"> ");

        //lus door de binnenkort films heem
        if (!isset($this->filmgroups['Binnenkort'])) { echo "<div class=\"GeenFilmsGevonden\">Er zijn geen films gevonden die aan de criteria voldoen.</div>"; }
        if (isset($this->filmgroups['Binnenkort'])) {
        foreach ($this->filmgroups['Binnenkort']['items'] as $film) {
            $kijwijzericonen = explode(",", $film['Kijkwijzer']);

            $kijkwijzerhtml = "";
            foreach ($kijwijzericonen as $icon) {
                $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/" . $icon . ".png\"/>";
            }
            echo ("
                    <div id=\"" . $film['FilmID'] . "\" class=\"filmoverzichtposter\">
                        <p>" . $film['KorteNaam'] . "</p>
                        <a href=\"films.php?filmid=" . $film['FilmID'] . "\"><img class=\"filoverzichtcover\" src=\"image/Covers/" . $film['Cover'] . "\"></a><br>
                        <strong>Genre</strong><br>" . $film['Genre'] . "<br>
                    " . $kijkwijzerhtml . "
                    </div>
                    ");

            if ($this->rowcount % 4 == 0 && $this->count != $this->filmgroups['Binnenkort']['count']) {
                echo '</div><div class="posterRow">';
                $this->rowcount = 0;
            }
            if ($this->count == $this->filmgroups['Nu']['count']) {
                echo '</div>';
            }
            $this->count++;
            $this->rowcount++;
        }
        }
        //binnenkortfilms div afsluiten           
        echo("</div></div></div>");

        //row modus divs
        //nufilms div openen
        echo ("
        <div id=\"Rows\">    
        <div id=\"NuFilmsRows\">");
        if (!isset($this->filmgroups['Nu'])) { echo "<div class=\"GeenFilmsGevonden\">Er zijn geen films gevonden die aan de criteria voldoen.</div>"; }
        if (isset($this->filmgroups['Nu'])) {
        foreach ($this->filmgroups['Nu']['items'] as $film) {
            $kijwijzericonen = explode(",", $film['Kijkwijzer']);
            $kijkwijzerhtml = "";

            foreach ($kijwijzericonen as $icon) {
                $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/" . $icon . ".png\"/>";
            }
            echo ("
                    <div class=\"posterRow\" >
                        <div id=\"" . $film['FilmID'] . "\" class=\"filmoverzichtposterrowview\">
                            <p>" . $film['KorteNaam'] . "</p>
                            <a href=\"films.php?filmid=" . $film['FilmID'] . "\"><img class=\"filoverzichtcoverrowview\" src=\"image/Covers/" . $film['Cover'] . "\"></a>
                            <strong>Genre</strong><br>" . $film['Genre'] . "
                            <br><br>
                            " . $kijkwijzerhtml . "
                            <br><br>
                            <div class=\"filmoverzichtbeschrijving\">" . $film['Beschrijving'] . "</div>
                        </div>
                    </div>");
        }
        }
        echo ("</div>");


        //binnenkortfilms div openen
        echo ("
        <div id=\"BinnenkortFilmsRows\">");
        if (!isset($this->filmgroups['Binnenkort'])) { echo "<div class=\"GeenFilmsGevonden\">Er zijn geen films gevonden die aan de criteria voldoen.</div>"; }
        if (isset($this->filmgroups['Binnenkort'])) {
        foreach ($this->filmgroups['Binnenkort']['items'] as $film) {
            $kijwijzericonen = explode(",", $film['Kijkwijzer']);
            $kijkwijzerhtml = "";

            foreach ($kijwijzericonen as $icon) {
                $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/" . $icon . ".png\"/>";
            }
            echo ("
                    <div class=\"posterRow\" >
                        <div id=\"" . $film['FilmID'] . "\" class=\"filmoverzichtposterrowview\">
                            <p>" . $film['KorteNaam'] . "</p>
                            <a href=\"films.php?filmid=" . $film['FilmID'] . "\"><img class=\"filoverzichtcoverrowview\" src=\"image/Covers/" . $film['Cover'] . "\"></a>
                            <strong>Genre</strong><br>" . $film['Genre'] . "
                            <br><br>
                            " . $kijkwijzerhtml . "
                            <br><br>
                            <div class=\"filmoverzichtbeschrijving\">" . $film['Beschrijving'] . "</div>
                        </div>
                    </div>");
        }
        }
        echo ("</div></div>");
    }

}
?>
