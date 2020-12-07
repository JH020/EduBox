<!DOCTYPE html>
<html>
    <head>
        <!-- Include standaard bestanden -->
        <?php include('../inc/head.php'); ?>

        <!-- Pagina informatie -->
        <title>Profielpagina</title>
		<meta charset="UTF-8">
        <meta name="description" content="Template voor groepsleden"/>
        <link rel="stylesheet" href="css/profielpagina.css" type="text/css">

    </head>
    <body>
		<!--header-->
        <?php include('../inc/header.php'); ?>

        <!--main content-->
        <div class="pageContent">
			<!--formulier voor schoolkeuze, studierichting, opleiding etc, -->
            <form> 
				<p><label for="firstName">First name:</label> 
				<input type="text" name="userFirstName"></p> 
				<p><label for="lastName">Sir name:</label> 
				<input type="text" name="userLastName"></p> 
				<p><label for="nameSchool">School:</label> 
					<select name=”userSchool”> 
						<option value=”nhlstendenEmmen”>NHL Stenden</option> 	
					</select></p> 
				<p><label for="locationSchool">Locatie:</label> 
					<select name=”locationSchool”> 
						<option value=”amsterdam”>Amsterdam</option> 	
						<option value=”assen”>Assen</option>
						<option value=”emmen”>Emmen</option> 
						<option value=”groningen”>Groningen</option> 
						<option value=”leeuwarden”>Leeuwarden</option>
						<option value=”meppel”>Meppel</option> 
						<option value=”terschelling”>Terschelling</option> 
						<option value=”zwolle”>Zwolle</option>
					</select></p> 
				<p><label for="typeCourse">Subject area</label> 
					<select name=”userSubjectArea”>
						<option value=”bestuurEnRecht”>Bestuur en Recht</option> 
						<option value=”CommunicatieEnMedia”>Communicatie en media</option> 
						<option value=”economieEnManagement”>Economie en Management</option> 
						<option value=”hotelmanagement”>Hotelmanagement</option> 
						<option value=”ict”>ICT</option> 
						<option value=”maritiem”>Maritiem</option> 
						<option value=”onderwijs”>Onderwijs</option> 
						<option value=”techniek”>Techniek</option> 
						<option value=”toerismeEnVrijeTijd”>Toerisme en vrije tijd</option> 
						<option value=”zorgEnWelzijn”>Zorg en Welzijn </option> 
					</select></p> 
        </div>
		
		<!--footer-->
        <?php include('../inc/footer.php'); ?>
    </body>
</html>