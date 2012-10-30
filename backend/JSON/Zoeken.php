<?php
if (!isset($_GET['q']))
{
 exit();
}
$query = urldecode($_GET['q']);
if (!isset($query)) {
    exit();
}

require_once('../Films.php');

$films = new Films();

echo json_encode( $films ->ZoekenNaarFilms($query, TRUE));
?>
