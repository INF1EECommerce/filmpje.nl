<?php

class Voorstellingen {

    var $connection;

    function Voorstellingen() {
        require_once(dirname(__FILE__) . '/DBConnection.php');

        $this->connection = new DBConnection();
    }

    public function HaalVoorstellingOp($voorstelling, $closeConnection) {
        if (!is_numeric($voorstelling)) {
            throw new Exception("Voorstelling is niet gezet.");
        }

        $this->connection->dbConnect();

        $query = mysql_query("
        SELECT * FROM voorstellingen WHERE voorstellingen.VoorstellingID = " . $voorstelling . "
        ");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de voorstelling. " . $voorstelling);
        }

        $row = mysql_fetch_array($query);

        if ($closeConnection) {
            $this->connection->dbClose();
        }

        return $row;
    }

    public function AlleVoorstellingen($closeConnection) {
        $this->connection->dbConnect();
        $query = mysql_query("SELECT Films.FilmID, films.Naam, voorstellingen.VoorstellingID, voorstellingen.Datum, voorstellingen.Tijd 
          FROM films 
          INNER JOIN voorstellingen ON voorstellingen.FilmID = films.FilmID");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de voorstellingen.");
        }


        $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }

        if ($closeConnection) {
            $this->connection->dbClose();
        }
        return $result;
    }

    public function VoorstellingenKomendeXDagen($dagen, $closeConnection) {
        if (!is_numeric($dagen)) {
            throw new Exception("dagenPlusMin is geen nummer.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT 
                            Naam AS FilmNaam,
                            films.FilmID,
                            voorstellingen.VoorstellingID AS VoorstellingID,
                            voorstellingen.Datum AS VoorstellingDatum,
                            voorstellingen.Tijd AS VoorstellingTijd,
                            voorstellingen.BeschikbareStoelen
                            FROM films
                            INNER JOIN voorstellingen on voorstellingen.FilmID = films.FilmID
                            WHERE voorstellingen.Datum <= DATE_ADD(NOW(), INTERVAL + " . $dagen . " DAY)
                            AND TIMESTAMP(voorstellingen.Datum, voorstellingen.Tijd) > NOW()
                            ORDER BY films.naam, voorstellingen.Datum, voorstellingen.Tijd");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de voorstellingen voor de komende X dagen. " . $dagen);
        }

        $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }

        if ($closeConnection) {
            $this->connection->dbClose();
        }

        return $result;
    }

    public function VoorstellingenVoorFilm($film, $closeConnection) {
        if (!is_numeric($film)) {
            throw new Exception("Film is geen nummer.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT 
                            voorstellingen.VoorstellingID AS VoorstellingID,
                            voorstellingen.Datum AS VoorstellingDatum,
                            voorstellingen.Tijd AS VoorstellingTijd,
                            voorstellingen.BeschikbareStoelen
                            FROM voorstellingen
                            WHERE voorstellingen.Datum <= DATE_ADD(NOW(), INTERVAL + 8 DAY)
                            AND voorstellingen.FilmID = " . $film . "
                            AND TIMESTAMP(voorstellingen.Datum, voorstellingen.Tijd) > NOW()
                            ORDER BY voorstellingen.Datum, voorstellingen.Tijd");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de voorstellingen voor film. " . $film);
        }

        $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }

        if ($closeConnection) {
            $this->connection->dbClose();
        }
        return $result;
    }

    public function VoorstellingenVoorSpecial($special, $closeConnection) {

        if (!is_numeric($special)) {
            throw new Exception("Special is geen nummer.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT 
                            films.FilmID,
                            films.Naam AS FilmNaam,
                            voorstellingen.VoorstellingID AS VoorstellingID,
                            voorstellingen.Datum AS VoorstellingDatum,
                            voorstellingen.Tijd AS VoorstellingTijd,
                            voorstellingen.BeschikbareStoelen
                            FROM voorstellingen
                            INNER JOIN films on films.FilmID = voorstellingen.FilmID
                            WHERE voorstellingen.SpecialID = " . $special . "
                            AND TIMESTAMP(voorstellingen.Datum, voorstellingen.Tijd) > NOW()
                            ORDER BY voorstellingen.Datum, voorstellingen.Tijd");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de films voor special. " . $special);
        }

        $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }

        if ($closeConnection) {
            $this->connection->dbClose();
        }
        return $result;
    }

}

?>
