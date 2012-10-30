<?php

class Films {

    var $connection;

    public function Films() {
        require_once(dirname(__FILE__) . '/DBConnection.php');
        $this->connection = new DBConnection();
    }

    public function BestaatFilm($filmId, $closeConnection) {
        if (!is_numeric($filmId)) {
            throw new Exception("FilmID is geen nummer.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("
        SELECT FilmID FROM films WHERE FilmID = " . $filmId . "
        ");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de film. " . $filmId);
        }


        $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }

        if ($closeConnection) {
            $this->connection->dbClose();
        }

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function HaalTop10FilmsOp($closeConnection) {

        $this->connection->dbConnect();
        $query = mysql_query("
        SELECT films.Naam AS FilmNaam, films.FilmID, ((SUM(zalen.AantalStoelen) - SUM(voorstellingen.BeschikbareStoelen)) / SUM(zalen.AantalStoelen)) AS PercentageVerkocht 
        FROM films 
        INNER JOIN voorstellingen on voorstellingen.FilmID = films.FilmID
        INNER JOIN zalen on zalen.ZaalID = voorstellingen.ZaalID
        GROUP BY films.FilmID, films.Naam
        ORDER BY ((SUM(zalen.AantalStoelen) - SUM(voorstellingen.BeschikbareStoelen)) / SUM(zalen.AantalStoelen)) DESC
        LIMIT 0, 10
        ");

        if (!$query) {
            throw new Exception("Er is iets misgegaan tijdens het ophalen van de top10 films.");
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

    public function ZoekenNaarFilms($query, $closeConnection) {

        if (strlen($query) == 0) {
            throw new Exception("Query is niet gezet.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("
        SELECT *, 'Naam' AS MatchType
        FROM `films`
        WHERE Naam LIKE '%" . $query . "%'

        UNION

        SELECT *, 'Acteur' AS MatchType
        FROM films
        WHERE Acteurs LIKE '%" . $query . "%'

        UNION

        SELECT *, 'Regisseur' AS MatchType
        FROM films
        WHERE Regisseur LIKE '%" . $query . "%'");

        if (!$query) {
            throw new Exception("Er ging iets mis tijdens het zoeken naar films. " . $query);
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

    public function FilmInfoVanVoorstelling($voorstelling, $closeConnection) {
        if (!is_numeric($voorstelling)) {
            throw new Exception("Voortselling is geen nummer.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT films.*, voorstellingen.*, zalen.Naam AS ZaalNaam 
                            FROM voorstellingen
                            INNER JOIN films on films.FilmID = voorstellingen.FilmID
                            INNER JOIN zalen on zalen.ZaalID = voorstellingen.ZaalID
                            WHERE voorstellingen.VoorstellingID = " . $voorstelling . " ");


        if (!$query) {
            throw new Exception("Er is iets misgegaan tijdens het ophalen van de filminfo voor voorstelling. " . $voorstelling);
        }

        $result = mysql_fetch_array($query);

        if ($closeConnection) {
            $this->connection->dbClose();
        }

        return $result;
    }

    public function FilmInfo($film, $closeConnection) {
        if (!is_numeric($film)) {
            throw new Exception("Film is geen nummer.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT films.*
                            FROM filmpje.films 
                            WHERE films.FilmID = " . $film . " ");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het opgalen van de filminfo. " . $film);
        }

        $result = mysql_fetch_array($query);

        if ($closeConnection) {
            $this->connection->dbClose();
        }

        return $result;
    }

    public function AlleFims($closeConnection) {
        $this->connection->dbConnect();
        $query = mysql_query("SELECT films.*, filmtypes.Naam AS FilmType
                            FROM filmpje.films
                            INNER JOIN filmtypes on filmtypes.FilmTypeID = films.FilmTypeID
                            ORDER BY films.KorteNaam
                            ");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de films.");
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

    public function HaalBannersOp($closeConnection) {
        $this->connection->dbConnect();
        $query = mysql_query("SELECT films.Banner, films.Naam, films.FilmID
                            FROM filmpje.films
                            WHERE films.Banner IS NOT NULL
                            ");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de Banners.");
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
