<?php

class BestellingOverzichtHeaderView {

    public function BestellingOverzichtHeaderView() {
        require_once('backend/Films.php');
    }

    public function Render($voorstelling) {

        $films = new Films();
        $filmInfo = $films->FilmInfoVanVoorstelling($voorstelling, TRUE);

        echo("
                <h2>" . $filmInfo['Naam'] . " - " . $filmInfo['Datum'] . " - " . substr($filmInfo['Tijd'], 0, 5) . " UUR</h2>
            ");
    }

}

?>
