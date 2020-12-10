<?php

require_once "../inc/config.php";

//variabelen defineren
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

//form data verwerken
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //klopt de gebruikersnaam?
    if(empty(trim($_POST["username"]))){
        $username_err = "vul aub een gebruikersnaam in";
    }
else{
    //een select statement klaarmaken
    $sql = "SELECT id FROM users WHERE username = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        //variabelen toevoegen aan klaargemaakte statement als eenn parameter
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        //parameters klaarmaken
        $param_username = trim($_POST["username"]);

        //proberen statement uit te voeren
        if(mysqli_stmt_execute($stmt)){
            //resultaten verzamelen
            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) == 1){
                $username_err = "deze gebruikersnaam is al in gebruik.";
            } else{
                $username = trim($_POST["username"]);
            }
        }else{
            echo "er ging iets fout, probeer het later opnieuw.";
        }
        mysqli_stmt_close($stmt);
    }
}
//valideren wachtwoord
if(empty(trim($_POST["password"]))){
    $password_err = "vul een wachtwoord in.";     
} elseif(strlen(trim($_POST["password"])) < 8){
    $password_err = "wachtwoord moet minimaal 8 karakters hebben.";
} else{
    $password = trim($_POST["password"]);
}
//hier moet ik controlleren op email stenden
$msg = "Er ging iets fout";
$email = $_POST["username"];
$password = $_POST["password"];
if(!empty($email) && !empty($password)) {
    $stringB = $email;
    $find = "nhlstenden.com";
    $resultaat = strchr($stringB,$find);  
    if (strpos($resultaat, "nhlstenden.com") === FALSE) {
        $acces = FALSE;
    }
    else {
        $acces = TRUE;
        $msg = "";
    }
    if ($acces === FALSE){
        $msg = "U heeft geen toegang tot dit platform zonder gebruik van een NHL Stenden account.";
    }
    else {
        $stringA = $email; 
        $toFind = "@";
        $result = strchr($stringA,$toFind);
        if(strpos($result, "student") === FALSE){
            $role = "docent";
    }
    else {
        $role = "student";
    } 

//valideren van accepteren wachtwoord
if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = "Graag het wachtwoord bevestigen.";     
} else{
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password)){
        $confirm_password_err = "wachtwoorden komen niet overheen.";
    }
}

//checken op errors voor dat het in de database komt
if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
    // voorbereiden insert statement
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    if($stmt = mysqli_prepare($link, $sql)){
        // prepared statements klaarmaken als parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

//parameters zetten
$param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); //hash voor wachtwoord maken

        //proberen prepared statement uit te voeren
        if(mysqli_stmt_execute($stmt)){
            // herleiden login pagina
            header("location: login.php");
        } else{
            echo "Er ging iets fout, probeer het later nog eens.";
        }
        //statement afsluiten
        mysqli_stmt_close($stmt);
    }
}
    //verbinding verbreken
    mysqli_close($link);      
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link rel="" href="">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Vul dit formulier in om een account aan te maken.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Gebruikersnaam</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Wachtwoord</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Bevestigen wachtwoord</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Heb je al een account? <a href="login.php">Hier inloggen</a>.</p>
        </form>
    </div>    
</body>
</html>