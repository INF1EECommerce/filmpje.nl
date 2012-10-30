<?php

class Zalen {

    var $connection;

    function Zalen() {
        require_once(dirname(__FILE__) . '/DBConnection.php');

        $this->connection = new DBConnection();
    }

    public function ZaalInfo($voorstelling, $closeConnection) {
        if (!is_numeric($voorstelling)) {
            throw new Exception("Voorstelling is geen nummer.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT rijen.Nummer as RijNummer, MAX(stoelen.Nummer) AS MaxStoelNummer, MIN(stoelen.Nummer) AS MinStoelNummer 
                            ,zalen.MaxStoelenPerRij, zalen.Rijen, zalen.LooppadBijStoelen, zalen.LooppadBijRijen
                            FROM
                            zalen
                            INNER JOIN rijen ON rijen.ZaalID = zalen.ZaalID
                            INNER JOIN voorstellingen on voorstellingen.ZaalID = zalen.ZaalID AND voorstellingen.VoorstellingID = " . $voorstelling . "
                            INNER JOIN stoelen ON stoelen.RijID = rijen.RijID
                            GROUP BY rijen.RijID");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de ZaalInfo. " . $voorstelling);
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
