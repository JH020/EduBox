<?php

/* Alle functies die over de website gebruikt worden */

// Validatie type thumbnail upload 
function isThumbnail($file)
{
    //Array met alle valide types van thumbnails
	$validTypes = array("image/jpg", "image/jpeg", "image/png");
    $fileType = $_FILES[$file]['type'];

    //Controle type
    if(in_array($fileType, $validTypes)){
        // Type is goed
        return true;
    } else{
        // Type is fout
        return false;
    }
}

// Thumbnail genereren uit titel en docent
function createThumbnail($title, $docent)  
{  
    // Canvas maken
    $image = imagecreate(1920, 1080);  

    //Functie om hex > rgb in te voegen voor background
    function hexKleur($image,$hex){
        $hex = ltrim($hex,'#');
        $a = hexdec(substr($hex,0,2));
        $b = hexdec(substr($hex,2,2));
        $c = hexdec(substr($hex,4,2));
        return imagecolorallocate($image, $a, $b, $c); 
    }

    // Array met mogelijke achtergrondkleuren
    $backgroundColors = array("#FFACA3", "#E841CB", "#A454FF", "#415BE8", "#69DBFF");
    
    // Selecteer een random item uit de lijst
    $color = $backgroundColors[array_rand($backgroundColors)];

    // Zet achtergrond met behulp van random kleur en functie
    hexKleur($image, $color);

    // Tekstkleur
    $textcolor = imagecolorallocate($image, 255,255,255); 
    
    // Marges en font grootte
    $topTitle = 450;
    $topDocent = 800;
    $titleSize = 120;
    $docentSize = 50;
    $left = 150;

    // Woorden afkappen bij lange titel
    $text_length = 20;
    html_entity_decode($title);
    $title = wordwrap($title, $text_length, "<br />", true);
    $title = str_replace('<br />', "\n", $title);

    // Tekst over canvas zetten
    imagettftext($image, $titleSize, 0, $left, $topTitle, $textcolor, dirname(__FILE__) . '/../fonts/arial.ttf', $title);  
    imagettftext($image, $docentSize, 0, $left, $topDocent, $textcolor, dirname(__FILE__) . '/../fonts/arial.ttf', $docent);  

    // Afbeelding naar BASE64 encoden voor database
    ob_start();
    imagepng($image);
    $imagedata = ob_get_clean();
    imagedestroy($image); 
    return base64_encode($imagedata);
    
}

// Validatie type bijlage upload 
function isAttachment($file)
{
    //Array met alle valide types van bijlage
    $validTypes = array("application/x-zip-compressed", ".zip", ".rar", ".7zip", "application/pdf");
    $fileType = $_FILES[$file]['type'];

    //Controle type
    if(in_array($fileType, $validTypes)){
        // Type is goed
        return true;
    } else{
        // Type is fout
        return false;
    }
}

// Validatie type video upload 
function isVideo($file)
{
    //Array met alle valide types van video
    $validTypes = array("video/mp4", "video/x-flv");
    $fileType = $_FILES[$file]['type'];

    //Controle type
    if(in_array($fileType, $validTypes)){
        // Type is goed
        return true;
    } else{
        // Type is fout
        return false;
    }
}


function videoID(){
    $videoID = substr(base64_encode(md5(uniqid(mt_rand(), true))), 0, 8);
    
    // Controle of waarde al bestaat
    $connectie = new mysqli(HOST, DBUSER, DBPWD, DATABASE);
    if ($connectie->connect_error) {
        die("Connectie mislukt: " . $connectie->connect_error);
    }

    $sql = "SELECT VideoID FROM video WHERE VideoID='$videoID'";
    $stmt = $connectie->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        //Waarde bestaat dus genereer een ander ID
        videoID();
    }
    $connectie->close();

    return $videoID;
}

?>