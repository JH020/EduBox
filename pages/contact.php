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

    </head>
    <body>
        <?php include('../inc/header.php'); ?>

        <!-- Content pagina -->
        <div class="pageContent">
            <form method="POST" ation="<?php echo $_SERVER['REQUEST_URI']; ?>" id="contactFormulier">
            <h1>Neem contact op</h1><br>
            <input type="text" name="naam" placeholder="Naam" required><br>
            <input type="email" name="naam" placeholder="E-mailadres" required><br>
            <textarea name="bericht" placeholder="Bericht" required></textarea>
            <input type="submit" name="submit" value="Versturen">
            </form>

            
            <div class="details">

            </div>
        </div>

        <?php include('../inc/footer.php'); ?>
    </body>
</html>