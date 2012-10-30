<?php

class DBConnection {

    var $conf;
    var $connection;

    function DBConnection() {
        $this->conf = $this->configData();
    }

    function configData() {
        $conf = array
            (
            'db_host' => 'localhost',
            'db_user' => 'filmpje',
            'db_pass' => 'filmpje',
            'db_data' => 'filmpje'
        );

        return $conf;
    }

    public function dbConnect() {
        if (!isset($this->connection)) {

            $this->connection = mysql_connect($this->conf['db_host'], $this->conf['db_user'], $this->conf['db_pass']);

            if (!$this->connection) {
                throw new Exception("Error tijdens verbinden met de dabase.");
            }

            $dbselected = mysql_select_db($this->conf['db_data'], $this->connection);

            if (!$dbselected) {
                throw new Exception("Error tijdens verbinden met de dabase.");
            }
        }
        return $this->connection;
    }

    public function dbClose() {
        if (isset($this->connection)) {

            $closed = mysql_close($this->connection);
            
            if (!$closed) {
                throw new Exception("Error tijdens verbinding verbreken met de dabase.");
            }
            $this->connection = NULL;
        }
        return true;
    }

}

?>
