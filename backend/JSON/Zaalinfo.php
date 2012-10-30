
<?php

$voorstellling = intval($_GET['voorstelling']);

if (!isset($voorstellling)) {
    exit();
}

require_once('../Zalen.php');

$zalen = new Zalen();

echo json_encode($zalen->ZaalInfo($voorstellling, TRUE));
?>

