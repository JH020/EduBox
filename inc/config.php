<?php

//Alle standaard waarden configureren over gehele webapplicatie

//DATABASE
define("HOST", "localhost");
define("DBUSER", "root");
define("DBPWD", "");
define("DATABASE", "edubox");

//EMAIL
define("SENDMAIL", "web@edubox.nl");

//DEBUGGEN (On/Off)
ini_set('display_errors', 'On');

//PHP SETTINGS
ini_set('max_execution_time', '300'); //Maximale executietijd van script in seconden
ini_set('max_input_time', '60'); //Maximale inputtijd voor POST en GET en File uploads in seconden
ini_set('memory_limit', '5120M'); //Max memory toegewezen aan PHP

?>