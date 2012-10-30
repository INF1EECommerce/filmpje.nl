<?php

class Stoelen {

    var $connection;

    function Stoelen() {
        require_once(dirname(__FILE__) . '/DBConnection.php');

        $this->connection = new DBConnection();
    }

    public function StoelInfo($stoelnummers, $closeConnection) {
        if (strlen($stoelnummers) == 0) {
            throw new Exception("Stoelnummers kan niet leeg zijn.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT stoelen.Nummer AS StoelNummer, rijen.Nummer AS RijNummer, stoeltypes.Naam AS StoelType, stoeltypes.Prijs AS StoelPrijs FROM stoelen 
          INNER JOIN stoeltypes on stoeltypes.StoelTypeID = stoelen.StoelTypeID     
          INNER JOIN rijen on rijen.RijID = stoelen.RijID
          WHERE stoelen.StoelID IN (
      " . $stoelnummers . "
      )");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de Stoelinfo.");
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

    public function BeschikbareStoelenVoorVoorstelling($voorstelling, $closeConnection) {
        if (!is_numeric($voorstelling)) {
            throw new Exception("Voorstelling is geen nummer.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT stoelen.StoelID, stoelen.Nummer AS StoelNummer, rijen.Nummer AS RijNummer, stoeltypes.Naam AS StoelType, stoeltypes.Prijs AS StoelPrijs 
                            FROM voorstellingen
                            INNER JOIN zalen ON zalen.ZaalID = voorstellingen.ZaalID
                            INNER JOIN stoelen ON stoelen.ZaalID = zalen.ZaalID
                            INNER JOIN stoeltypes ON stoeltypes.StoelTypeID = stoelen.StoelTypeID
                            INNER JOIN rijen ON rijen.RijID = stoelen.RijID
                            WHERE stoelen.StoelID NOT IN 
                            (
                                SELECT StoelID FROM bestellingstoelen
                                INNER JOIN bestellingen on bestellingen.BestellingID = bestellingstoelen.BestellingID 
                                AND bestellingen.BestellingStatusID != 5 
                                AND bestellingen.VoorstellingID = " . $voorstelling . "
                            )
                            AND stoelen.StoelID NOT IN 
                            (
                                SELECT StoelID FROM
                                (
                                SELECT StoelID, voorstellingen.Datum, voorstellingen.Tijd, reserveringen.ReserveringStatusID FROM reserveringstoelen       
                                INNER JOIN reserveringen on reserveringen.ReserveringID = reserveringstoelen.ReserveringID 
                                INNER JOIN voorstellingen on voorstellingen.VoorstellingID = reserveringen.VoorstellingID
                                AND reserveringen.VoorstellingID = " . $voorstelling . "
                                AND reserveringen.ReserveringStatusID != 3
                                ) gs
                                WHERE (TIMESTAMP(gs.Datum, gs.Tijd) > TIMESTAMP(DATE_ADD(NOW(), INTERVAL 30 MINUTE)) AND gs.ReserveringStatusID = 1)
                                OR (gs.ReserveringStatusID = 2) 
                            )
                            AND voorstellingen.VoorstellingID = " . $voorstelling . " ");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de beschikbare stoelen voor voorstelling. " . $voorstelling);
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
