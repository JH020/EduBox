<?php
// sessie starten
session_start();
 
// alle sessie variabelen selecteren
$_SESSION = array();
 
// sessie destroyen
session_destroy();
 
// terug sturen naar login pagina
header("location: login.php");
exit;
?>