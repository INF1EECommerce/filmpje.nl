<?php
if (!isset($_GET['km'])) {
  die;  
}
include_once 'backend/Reserveringen.php';

$reserveringen = new Reserveringen();
try
{
$reserveringen->ReserveringOphalen($_GET['km']);
header("Location: index.php?m=ROS");
} catch (Exception $ex)
{
    header("Location: index.php?m=" . urldecode($ex->getMessage()));
}
?>