<!DOCTYPE html>
<html>
    <head>
        <!-- Include standaard bestanden -->
        <?php include('../inc/head.php'); ?>

        <!-- Pagina informatie -->
        <title>Contact</title>
        <meta name="description" content="Neem contact op"/>
        <link rel="stylesheet" href="css/contact.css">
        <link rel="stylesheet" href="css/noHeader.css">

        <?php
        $emptyFields = array();
        if(isset($_POST['submit'])){
            if(!empty($_POST['naam'])){
                if(!empty($_POST['email'])){
                    if(!empty($_POST['bericht'])){
                        // Alle gegevens zijn ingevuld
                        $naam = filter_var($_POST['naam'], FILTER_SANITIZE_STRING);
                        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                        $bericht = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                        $onderwerp = "Contactformulier";
                        $headers = "From: ".$email;

                        //Mail versturen (default mail(), omdat functie niet echt in gebruik wordt genomen, anders had een PHPMailer met SMTP beter geweest)
                        mail(SENDMAIL,$onderwerp,$bericht,$headers);
                        //Geeft error wanneer geen SMTP server is gevonden of is geconfigureerd
                        
                    } else{
                        // Leeg bericht
                        array_push($emptyFields, "Bericht");
                    }
                } else{
                    // Lege email
                    array_push($emptyFields, "E-mailadres");
                    if(empty($_POST['bericht'])){
                        array_push($emptyFields, "Bericht");
                    }
                }
            } else{
                //Lege naam
                array_push($emptyFields, "Naam");
                if(empty($_POST['email'])){
                    array_push($emptyFields, "E-mailadres");
                }
                if(empty($_POST['bericht'])){
                    array_push($emptyFields, "Bericht");
                }
            }
        }
        ?>

    </head>
    <body>
        <?php include('../inc/header.php'); ?>

        <!-- Content pagina -->
        <div class="pageContent">
            <form method="POST" ation="<?php echo $_SERVER['REQUEST_URI']; ?>" id="contactFormulier">
            <h1>Neem contact op</h1><br>
            <input type="text" name="naam" placeholder="Naam" required><br>
            <input type="email" name="email" placeholder="E-mailadres" required><br>
            <textarea name="bericht" placeholder="Bericht" required></textarea><br><br>
            <input type="submit" name="submit" value="Versturen">
            </form>            
            <div class="details">
                <!-- Eventuele details van locatie's of emailadressen -->
                <?php
                if(isset($_POST['submit']) && count($emptyFields) > 0){
                    echo "<p id=\"errorFields\">Let op!</p><br>";
                    foreach($emptyFields as $field){
                    echo "<p>".$field." veld is leeg.</p>";             
                    }
                }
                ?>
            </div>
        </div>

        <?php include('../inc/footer.php'); ?>
    </body>
</html>