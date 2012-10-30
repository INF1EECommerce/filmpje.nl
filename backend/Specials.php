<?php

class Specials {

    var $connection;

    function Specials() {
        require_once(dirname(__FILE__) . '/DBConnection.php');

        $this->connection = new DBConnection();
    }

    public function HaalSpecialOp($special, $closeConnection) {

        if (!is_numeric($special)) {
            throw new Exception("Special is geen nummer.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT specials.*
                            FROM filmpje.specials
                            WHERE specials.SpecialID = " . $special . "
                            ");


        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de special. " . $special);
        }

        $result = mysql_fetch_array($query);

        if ($closeConnection) {
            $this->connection->dbClose();
        }

        return $result;
    }

    public function HaalSpecialsOp($closeConnection) {
        $this->connection->dbConnect();
        $query = mysql_query("SELECT specials.*
                            FROM filmpje.specials
                            ");


        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de specials.");
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

    public function BestaatSpecial($special, $closeConnection) {

        if (!is_numeric($special)) {
            throw new Exception("Special is geen getal.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("
        SELECT SpecialID FROM specials WHERE SpecialID = " . $special . "
        ");

        if (!$query) {
            throw new Exception("Er ging iets mis bij het bepalen of de special bestond. " . $special);
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

}

?>
