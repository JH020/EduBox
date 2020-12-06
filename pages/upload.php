<!DOCTYPE html>
<html>
    <head>
        <!-- Include standaard bestanden -->
        <?php include('../inc/head.php'); ?>

        <!-- Pagina informatie -->
        <title>Video uploaden</title>
        <meta name="description" content="Upload een video"/>
        <link rel="stylesheet" href="css/upload.css">
        <link rel="stylesheet" href="css/noHeader.css">

        <?php
            //Valideren gegevens en in database zetten
            if(isset($_POST['submit']) && isset($_POST['title']) && isset($_POST['beschrijving']) && isset($_POST['opleiding']) && isset($_POST['tags']) && isset($_FILES['video'])){
                if(!empty($_POST['title']) && !empty($_POST['beschrijving']) && !empty($_POST['opleiding']) && !empty($_POST['tags'])){
                    //Alle benodigde gegevens zijn ingevuld
                    $invoerError = array();

                    // Docent gegevens
                    $docent = "Gerjan van Oenen";
                    $UserID = "abcdefgh";

                    //Sanitizen van text-input
                    $titel = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
                    $beschrijving = filter_var($_POST['beschrijving'], FILTER_SANITIZE_STRING);

                    if (strlen($titel) > 255){
                        $titel = substr($titel, 0, 252) . '...';
                    }

                    if (strlen($beschrijving) > 255){
                        $beschrijving = substr($beschrijving, 0, 252) . '...';
                    }
                    
                    //Opleidingen in array
                    $EducationID = filter_var($_POST['opleiding'], FILTER_SANITIZE_STRING);

                    //Tags in array ($tag[0], $tag[1]...)
                    $tag = explode(",", str_replace("", " ", $_POST['tags']));


                    //Thumbnail validatie
                    if(isThumbnail("thumbnail")){
                        $thumbnailImage = base64_encode(file_get_contents($_FILES['thumbnail']['tmp_name']));       
                        $thumbnailType = $_FILES['thumbnail']['type'];                               
                    } else{
                        // Geen valide type bestand >> Genereer zelf bestand
                        $thumbnailImage = createThumbnail($titel, $docent);
                        $thumbnailType = "image/png";
                        array_push($invoerError, "Geen thumbnail meegestuurd, je gebruikt nu de automatisch gegenereerde afbeelding.");
                    }

                    //Bijlage validatie
                    if(isAttachment("attachment")){
                        $attachment = base64_encode(file_get_contents($_FILES['attachment']['tmp_name']));       
                        $attachmentType = $_FILES['attachment']['type'];          
                    } else{
                        $attachment = NULL;
                        $attachmentType = NULL;
                        array_push($invoerError, "Bijlage is niet in het juiste bestandsformaat en is niet opgeslagen.");
                    }

                    // Video validatie
                    if(isVideo("video")){
                        $VideoID = videoID();
                        $VideoType = $_FILES['video']['type'];
                        if($VideoType == "video/mp4"){
                            $extention = ".mp4";
                        } else {
                            $extention = ".flv";
                        }
                        $VideoFile = "../video/".$VideoID.$extention;
                    } else{
                        $error = "Verkeerd bestandsformaat voor de video, probeer een mp4 of flv te uploaden.";
                        header("Location: upload");
                    }
                    
                    //Verbinding met database maken en valideren [video]
                    $conn = new mysqli(HOST, DBUSER, DBPWD, DATABASE);
                    if ($conn->connect_error) {
                        die("Connectie mislukt: " . $conn->connect_error);
                    }

                    // Query voorbereiden [video]
                    $stmt = $conn->prepare("INSERT INTO video (VideoID, Title, UserID, EductionID, VideoFile, VideoType, Description, Thumbnail, ThumbnailType, Attachment, AttachmentType) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssssss", $VideoID, $titel, $UserID, $EducationID, $VideoFile, $VideoType, $beschrijving, $thumbnailImage, $thumbnailType, $attachment, $attachmentType);
                    
                    // Query uitvoeren [video]
                    if ($stmt->execute()) { 
                        // Succes met invoeren
                        if(empty($errors)==true){
                            $file_tmp =$_FILES['video']['tmp_name'];
                            move_uploaded_file($file_tmp, $VideoFile);
                         }else{
                            print_r($errors);
                         }
                     } else {
                        // Er ging iets mis
                        echo $stmt->error;
                        die();
                     }

                    // Connectie sluiten [video] 
                    $stmt->close();
                    $conn->close();

                    //Verbinding met database maken en valideren [tag]
                    $conn = new mysqli(HOST, DBUSER, DBPWD, DATABASE);
                    if ($conn->connect_error) {
                        die("Connectie mislukt: " . $conn->connect_error);
                    }

                    foreach($tag as $tagValue){
                        // Query voorbereiden [tag]
                        $stmt = $conn->prepare("INSERT INTO tag (VideoID, TagData) VALUES (?, ?)");
                        $stmt->bind_param("ss", $VideoID, $tagValue);
                        
                        // Query uitvoeren [tag]
                        if ($stmt->execute()) { 
                            // Succes met invoeren
                        } else {
                            // Er ging iets mis
                            echo $stmt->error;
                            die();
                        }
                    }

                    // Connectie sluiten [tag] 
                    $stmt->close();
                    $conn->close();

                    if(!isset($error)){                        
                        header("Location: home");
                    }

                    if(!isset($invoerError)){                        
                        header("Location: home");
                    }

                } else{
                    $error = "Niet alle gegevens zijn ingevuld";
                }
            } elseif(isset($_POST['submit'])){
                $error = "Niet alle gegevens zijn ingevuld";
            }
        ?>

    </head>
    <body>
        <?php include('../inc/header.php'); ?>

        <!-- Content pagina -->
        <div class="pageContent">
            <div class="upload">
                <form id="uploadForm" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" autocomplete="off">
                    <h1>Upload een video</h1><br>

                    <?php
                        //Error melding wanneer niet alle velden ingevuld zijn
                        if(isset($error)){
                            echo "<p class=\"error\">".$error."</p><br>";
                        }
                        if(isset($invoerError)){
                            foreach($invoerError as $value)
                            echo "<p class=\"error\">".$value."</p><br>";
                        }
                    ?>

                    <br>

                    <label for="title"><p>Titel</p></label>
                    <input type="text" id="title" name="title" placeholder="Titel" required>

                    <label for="beschrijving"><p>Beschrijving</p></label>
                    <textarea name="beschrijving" id="beschrijving" placeholder="Beschrijving" required></textarea>

                    <label for="attachment"><p>Bijlage</p></label>
                    <input type="file" name="attachment" id="attachment" accept=".zip,.rar,.7zip,application/pdf">

                    <label for="video"><p>Video</p></label>
                    <input type="file" name="video" id="video" accept="video/x-flv, video/mp4">
                    
                    <label for="thumbnail"><p>Thumbnail</p></label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/png, image/jpeg">

                    <label for="opleiding"><p>Opleiding</p></label>
                    <!-- <select name="opleiding[]" id="opleiding multiple? -->
                    <select name="opleiding" id="opleiding">
                        <option selected disabled>Selecteer een opleiding</option>
                        <option value="1">Opleiding 1</option>
                        <option value="2">Opleiding 2</option>
                        <option value="3">Opleiding 3</option>
                        <option value="4">Opleiding 4</option>
                    </select>

                    <label for="tags"><p>Tags</p></label>
                    <textarea name="tags" id="tags" placeholder="Tag, tag, tag..." required></textarea>

                    <br><br>
                    <input type="submit" id="submit" name="submit" value="Video uploaden">
                </form>
            </div>
        </div>

        <?php include('../inc/footer.php'); ?>
    </body>
</html>