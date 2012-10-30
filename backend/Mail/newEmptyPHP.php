<?php
include_once 'SendEmail.php';
$sendEmail = new SendEmail();
$sendEmail->ZendEmailForSuccesBetaling("4watsh8tgx");
$sendEmail->ZendEmailForSuccesReservering($data);
?>
