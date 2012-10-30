<?php
if (!isset($_GET['km'])) {
  die;  
}
include_once 'backend/Reserveringen.php';

$reserveringen = new Reserveringen();
try
{
$reserveringen->ReserveringOphalen($_GET['km'], TRUE);
header("Location: index.php?m=".  urlencode("Reservering succesvol gemarkeerd als opgehaald."));
} catch (Exception $ex)
{
    header("Location: index.php?m=" . urldecode($ex->getMessage()));
}
?>