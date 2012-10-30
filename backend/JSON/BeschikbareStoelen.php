<?php

$voorstellling = intval($_GET['voorstelling']);

if (!isset($voorstellling)) {
    exit();
}
require_once('../Stoelen.php');

$stoelen = new Stoelen();

echo json_encode($stoelen->BeschikbareStoelenVoorVoorstelling($voorstellling, TRUE));
?>
