<?php
// sessie beginnen
session_start();
 
// Controlleer als de gebruiker is ingelogd, anders naar de login pagina
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Include standaard bestanden -->
        <?php include('../inc/head.php'); ?>

        <!-- Pagina informatie -->
        <title>Home</title>
        <meta name="description" content="Homepagina EduBox"/>
        <link rel="stylesheet" href="css/home.css">

        <?php
            //Gebruiker gegevens
            $docent = "Gerjan van Oenen";
            $UserID = "abcdefgh";

            //Header
            $interesses = getOpleidingen($UserID);
            
        ?>

    </head>
    <body>
        <?php include('../inc/header.php'); ?>

        <!-- Content pagina -->
        <div class="pageContent">
            <?php


            ?>
        </div>

        <?php include('../inc/footer.php'); ?>
    </body>
</html>