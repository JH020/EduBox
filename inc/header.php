<!-- Header -->

<div class="header">
    <div class="navBar">
        <a href="home" class="logo"></a>
        <div class="nav">
            <a href="home">Home</a>
            <a href="#">Alle video's</a>
            <a href="#">Mijn lijst</a>
            <a href="#">Vakken</a>
            <a href="#">Docenten</a>
            <div class="dropdown">
                <button class="dropbtn"><i class="fa fa-user-o"></i>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">

                    <a href="#">Mijn profiel</a>

                    <a href="#">Geschiedenis</a>
                    
                    <a href="#">Gelikte video's</a>

                    <!-- Alleen voor docenten -->
                    <a href="#">Videobeheer</a>

                    <a href="#">Uitloggen</a>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="headerContent">
        <?php
        //Interesses
        if(isset($interesses)){
            if(!empty($interesses)){
                $randIndex = array_rand($interesses);
                $interesse = $interesses[$randIndex];
            } else{
                $interesse = 0;
            }
            //Genereer details        
            $VideoInfo = selectData("SELECT VideoID, Title, Thumbnail, ThumbnailType, Description, EducationID FROM video WHERE EducationID = $interesse ORDER BY RAND() LIMIT 1")->fetch_assoc();
            $VideoID = $VideoInfo['VideoID'];
            $Titel = $VideoInfo['Title'];
            $Beschrijving = $VideoInfo['Description'];
            $EductionID = $VideoInfo['EducationID'];
            $Thumbnail = $VideoInfo['Thumbnail'];
            $ThumbnailType = $VideoInfo['ThumbnailType'];
            $ThumbnailGradient= "linear-gradient(90deg, rgba(4,99,133,0.5410539215686274) 0%, rgba(82,10,102,0.5942752100840336) 100%),";
            $ThumbnailBackground = "data:".$ThumbnailType.";base64,".$VideoInfo['Thumbnail'];

            ?>

            <style>            
                .header{
                    background-image: <?php echo $ThumbnailGradient; ?>url('<?php echo $ThumbnailBackground; ?>');
                }
            </style>

            <?php   

        }

        
                  

        //Als waarde toch leeg blijkt te zijn
        if(empty($VideoID)){
            $VideoID = "ERROR";
            $Titel = "Titel";
            $Beschrijving = "Beschrijving";
        }

        ?>
        <div class="infoVideo">
            <h1><?php echo $Titel; ?></h1>
            <p><?php echo $Beschrijving; ?></p>
        </div>
        <div class="playVideo">
            <a href="#"><i class="fa fa-play" aria-hidden="true"></i><br><p class="play">Bekijken</p></a>
        </div>
    </div>
</div>