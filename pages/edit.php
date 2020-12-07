<!DOCTYPE html>
<html>
    <head>
        <!-- Include standaard bestanden -->
        <?php include('../inc/head.php'); ?>

        <!-- Pagina informatie -->
        <title>Video bijwerken</title>
        <meta name="description" content="Werk een video bij"/>
        <link rel="stylesheet" href="css/upload.css">
        <link rel="stylesheet" href="css/noHeader.css">

        <?php
            // Docent gegevens
            $docent = "Gerjan van Oenen";
            $UserID = "abcdefgh";

            if(!isset($_GET['id'])){
                die();
            } else {
                $VideoID = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
            }

            //Huidige gegevens inladen
            //Verbinding met database maken en valideren [video]
            $conn = new mysqli(HOST, DBUSER, DBPWD, DATABASE);
            if ($conn->connect_error) {
                die("Connectie mislukt: " . $conn->connect_error);
            }
            //Query
            $sql = "SELECT video.*
                    FROM video WHERE VideoID = ? AND UserID = ?
                    LIMIT 1";

            //Prepare en bind VideoID en UserID
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $VideoID, $UserID);
            $stmt->execute();
            $result = $stmt->get_result();

            //Alle info van video in variabele
            while ($row = $result->fetch_assoc()) {
                $VideoID = $row['VideoID'];
                $Title = $row['Title'];
                $EductionID = $row['EducationID'];
                $Thumbnail = $row['Thumbnail'];
                $ThumbnailType = $row['ThumbnailType'];
                $Vote = $row['Vote'];
                $Attachment = $row['Attachment'];
                $AttachmentType = $row['AttachmentType'];
                $Description = $row['Description'];
                $Created = $row['Created'];
            }

            $conn->close();
            $stmt->close();

            //Verbinding met database maken en tags inladen [tag]
            $conn = new mysqli(HOST, DBUSER, DBPWD, DATABASE);
            if ($conn->connect_error) {
                die("Connectie mislukt: " . $conn->connect_error);
            }

            //Query
            $sql = "SELECT * FROM tag WHERE VideoID = ?";

            //Prepare en bind VideoID
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $VideoID);
            $stmt->execute();
            $result = $stmt->get_result();

            $tags = array();

            //Alle tags in array
            while ($row = $result->fetch_assoc()) {
                array_push($tags, $row['TagData']);
            }

            $conn->close();
            $stmt->close();

            //Validatie gegevens
        ?>

    </head>
    <body>
        <?php include('../inc/header.php'); ?>

        <!-- Content pagina -->
        <div class="pageContent">
            <div class="upload">
                <form id="uploadForm" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" autocomplete="off">
                    <h1>Bewerk <?php ?></h1><br>
                    <div class="data">
                        <div class="left">
                        <?php
                            echo "<p>".$Title."</p>";
                            echo "<p>".$Description."</p>";
                            echo "<p>".
                                foreach($tags as $tag){

                                }.
                            "</p>";
                            echo "<p>".$Title."</p>";

                        ?>
                        </div>
                    </div>
                    
                    <br><br>
                    <input type="submit" id="submit" name="submit" value="Video bewerken">
                </form>
            </div>
        </div>

        <?php include('../inc/footer.php'); ?>
    </body>
</html>