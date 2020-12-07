<?php

//Alle standaard waarden configureren over gehele webapplicatie

//DATABASE
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'edubox');

//EMAIL
define("SENDMAIL", "web@edubox.nl");

//DEBUGGEN (On/Off)
ini_set('display_errors', 'On');

//PHP SETTINGS
ini_set('max_execution_time', '300'); //Maximale executietijd van script in seconden
ini_set('max_input_time', '60'); //Maximale inputtijd voor POST en GET en File uploads in seconden
ini_set('memory_limit', '5120M'); //Max memory toegewezen aan PHP

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);   //controleren op connectie
if($link === false){
    die("U heeft geen toegang. " . mysqli_connect_error());
}

?>