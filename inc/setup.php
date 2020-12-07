<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Setup EduBox Database</title>
        <link rel="stylesheet" href="../css/style.css">
        <style>
            html, body{
                margin: 20px;
                font-family: sans-serif;
            }

            pre{
                color: green;
            }

            a{
                border-bottom: 1px solid white;
            }
        </style>
    </head>
    <body>
        <?php

            //Standaard waarden importeren
            include('config.php');

            //Verbinding met database maken en valideren
            $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
            if ($conn->connect_error) {
            die("Connectie mislukt: " . $conn->connect_error);
            }

            //Nieuwe database aanmaken
            $stmt = $conn->prepare("CREATE DATABASE edubox");
            $stmt->execute();
            $stmt->close();

            //Tabellen importeren vanuit edubox.sql
            $db = new PDO("mysql:host=".DB_SERVER.";dbname=edubox", DB_USERNAME, DB_PASSWORD);
            $query = file_get_contents("edubox.sql");
            $stmt = $db->prepare($query);
            if ($stmt->execute()){
                echo "<h1>Uitgevoerde query succesvol</h1><br>";
                echo "<a href=\"../home\">Ga naar homepagina van applicatie</a><br><br>";
                echo "<pre>".$query."</pre>";
            }else{ 
                echo "<p>Er is iets mis gegaan. Probeer de database handmatig te uploaden.</p>";
            }
            $conn=null;

        ?>
    </body>
</html>