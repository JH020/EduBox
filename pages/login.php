<?php
// sessie beginnen altijd bovenaan!
session_start();
 
// controlleren als gebruiker al ingelogd is
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// verwijzen config
require_once "../inc/config.php";
 
// nieuwe lege variabelen defineren
$username = $password = "";
$username_err = $password_err = "";
 
// als de form is ingezonden dit gaan uitvoeren
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // controle lege gebruikersnaam
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // controle wachtwoord leeg ja of nee
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // credentials conntroleren
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // variabelen combineren met statements en parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // parameters maken
            $param_username = $username;
            
            // uitvoeren prepared statements
            if(mysqli_stmt_execute($stmt)){
                // resultaten opslaan
                mysqli_stmt_store_result($stmt);
                
                // controleren als gebruikersnaam bestaat, zo ja wachtwoord controleren
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // variabelen combineren
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // wachtwoord klopt, nieuwe sessie starten
                            session_start();
                            
                            // data in sessie variabelen opslaan
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // naar de home pagina
                            header("location: home.php");
                        } else{
                            // error bericht laten zien als dit niet klopt
                            $password_err = "Het wachtwoord is onjuist.";
                        }
                    }
                } else{
                    // error bericht als gebruikersnaam niet bestaat
                    $username_err = "Er is geeb account gevonden met deze gebruikersnaam.";
                }
            } else{
                echo "Er ging iets fout, probeer het later nogmaals.";
            }

            // statement afsluiten
            mysqli_stmt_close($stmt);
        }
    }
    
    // connectie sluiten
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <?php include('../inc/header.php'); ?>

    <div class="wrapper">
        <h2>Login</h2>
        <p>Vul uw gegevens in om in te loggen.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <li><label for="email"><b>Email *</b></label></li>
                <li><input id="login" type="text" name="username" placeholder="Vul hier uw email in..." class="form-control" value="<?php echo $username; ?>"></li>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <li><label for="wachtwoord"><b>Wachtwoord *</b></label></li>
                <li><input id="login" type="password" name="password" placeholder="Vul hier uw wachtwoord in..." class="form-control"></li>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Heeft u nog geen account? <a href="registration.php">regristreer nu!</a>.</p>
        </form>
    </div>

    <?php include('../inc/footer.php'); ?>
</body>
</html>