<?php

class DBConnection
{
    var $conf;
    var $connection;
    
    function DBConnection()
    {
        $this -> conf = $this ->configData();
    }


    function configData()
    {
    $conf = array
    (
        'db_host' => 'localhost',
        'db_user' => 'filmpje',
        'db_pass' => 'filmpje',
        'db_data' => 'filmpje'
    );

    return $conf;
    }

    
    public function dbConnect()
    {
        if (!isset($this -> connection )) {

        $this -> connection = mysql_connect($this -> conf['db_host'], $this -> conf['db_user'], $this -> conf['db_pass']) or die(mysql_error());
        mysql_select_db($this -> conf['db_data'], $this -> connection) or die(mysql_error());
        
        }
        return $this -> connection;
    }

    public function dbClose()
    {
        if (isset($this -> connection)) {

        mysql_close($this -> connection) or die(mysql_error());
        $this -> connection = NULL;
                    
        }
        return true;
    }

}

?>
