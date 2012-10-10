<?php
require_once 'backend/Bestellingen.php';

$b = new Bestellingen();

$b->UpdateBeschikbareStoelenBetaalProbleem($_GET['k']);

?>
