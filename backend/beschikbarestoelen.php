<?php
$voorstellling = intval($_GET['voorstelling']);

if (!isset($voorstellling)) {
    exit();
}

require_once(dirname(__FILE__).'/DBFunctions.php');

$dbfunctions = new DBFunctions();

echo json_encode( $dbfunctions ->BeschikbareStoelenVoorVoorstelling($voorstellling));
?>
