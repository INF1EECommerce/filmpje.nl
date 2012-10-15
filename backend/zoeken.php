<?php
if (!isset($_GET['q']))
{
    echo "Error";
    die;
}
$query = $_GET['q'];
if (!isset($query)) {
    exit();
}

require_once(dirname(__FILE__).'/DBFunctions.php');

$dbfunctions = new DBFunctions();

echo json_encode( $dbfunctions ->ZoekenNaarFilms($query));
?>
