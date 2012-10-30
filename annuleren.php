<?php
if (!isset($_GET['km'])) {
  die;  
}
include_once 'backend/Reserveringen.php';

$reserveringen = new Reserveringen();
try
{
$reserveringen->ReserveringAnnuleren($_GET['km'], TRUE);
header("Location: index.php?m=".  urlencode("Uw reservering is succesvol geannuleerd."));
} catch (Exception $ex)
{
    header("Location: index.php?m=" . urldecode($ex->getMessage()));
}
?>
