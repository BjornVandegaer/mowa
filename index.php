<!DOCTYPE html>
<html lang ="nl-be">

<head>
	<title>Monumentenwacht</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<!-- Tuurlijk heb ik eigen css -->
	<link href="css/stylesheet.css" type="text/css" rel="stylesheet"/>

	<!-- php connectie -->
	<?php
	include 'Config.php';
	$servername = constant("DBHOST");
	$usernameDB = constant("DBUSER");
	$passwordDB = constant("DBPASS");
	$mydb = constant("DBNAME");

	// Create connection
	$conn = new mysqli($servername, $usernameDB, $passwordDB, $mydb);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	?>

	<!-- script voor zoekbalk voor alle search-box class -->

	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
	    $('.search-box input[type="text"]').on("keyup input", function(){
	        /* Get input value on change */
	        var inputVal = $(this).val();
	        var resultDropdown = $(this).siblings(".result");
	        if(inputVal.length){
	            $.get("Search.php", {term: inputVal}).done(function(data){
	                // Display the returned data in browser
	                resultDropdown.html(data);
	            });
	        } else{
	            resultDropdown.empty();
	        }
	    });

	    // Set search input value on click of result item
	    $(document).on("click", ".result p", function(){
	        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
	        $(this).parent(".result").empty();
	    });
	});
	</script>
  </script>

</head>

<body>
	<!-- Navigatiebar -->
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">aanklikken navigatie</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<p class="navbar-brand">Monumentenwacht</p>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#">Metingen en vastellingen</a></li>
					<li><a href="#">Vragen aan verantwoordelijke </a></li>
					<li><a href="#">Itemniveau</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- Zoekbalk -->
	<div class="container">
		<div class="row">
			<div class="col-sm-5 col-md-5">
				<form action="Search3.php" method="Get" class="navbar-form" role="search">
		<!--			<div class="input-group"> -->
		<div class= "search-box">
						<input type="text" class="form-control" autocomplete="off" placeholder="Search" name="query" >
						<div class="result"></div>
						<div class="input-group-btn">

							<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Selectiebar links -->
	<!-- For in Label & id input moet altijd HETZELFDE zijn -->
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<form action="" method="post">
					<label for="gemeenten">Gemeente</label>
					<select class="form-control" id="gemeenten" >

						<!--	<select multiple class="form-control" id="gemeenten"> -->



						<?php

						$sql = "SELECT `tblGemeenten`.`Gemeente` FROM `tblGemeenten` ORDER BY `tblGemeenten`.`Gemeente` ASC";

						if($result = mysqli_query($conn, $sql)){
							if(mysqli_num_rows($result) > 0){

								while($row = mysqli_fetch_array($result)){

									echo "<option value='{$row[0]}'>{$row[0]}</option>";
								}

							}}

							?>

						</select>
						<!--		</select> -->
					</form>
				</div>



				<!-- Selectiebar rechts -->
				<div class="col-md-4">
					<form action="" method="post">
						<label for="kerken">Kerken</label>
						<select class="form-control" id="kerken">

							<?php

							$sql = "SELECT `tblObjecten`.`Objectnaam` FROM `tblObjecten` ORDER BY `tblObjecten`.`Objectnaam` ASC";

							if($result = mysqli_query($conn, $sql)){
								if(mysqli_num_rows($result) > 0){

									while($row = mysqli_fetch_array($result)){

										echo "<option value='{$row[0]}'>{$row[0]}</option>";
									}

								}}

								?>


							</select>
						</form>
					</div>
					<!-- Foto -->
					<div class="col-md-4">
						<div>
							<img class="img-responsive center-block" src="images/12687-2.jpg" alt="geimporteerde foto">
						</div>
					</div>
				</div>
			</div>

			<!-- Knop selectie data-toggle= om de modal te activeren binnen de knop-->

			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<a href="#keuze" class="btn btn-danger btn-lg" role="button" data-toggle="modal">Volgende</a>
					</div>
				</div>
			</div>

			<!-- Fixed footer onderaan + gebruiker  -->
			<div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
				<div class="container">
					<form class="form-inline" action="" method="post">
						<div class="form-group">
							<div class="col-xs-8">
								<input type="text" class="form-control" id="gebruiker" value="" readonly>
							</div>
						</div>
						<button type="submit" class="btn btn-secondary">Uitloggen</button>
					</form>
				</div>
			</div>
			<!-- modal => note: data-dismiss= om de modal af te sluiten  -->

			<div class="modal fade" id="keuze" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4>Vragenlijsten</h4>
						</div>
						<div class="modal-body">

							<a href="#" class="btn btn-primary center-block" role="button" >Metingen en vastellingen</a><br/>
							<a href="#" class="btn btn-success center-block" role="button" >Vragen aan verantwoordelijke</a><br/>
							<a href="#" class="btn btn-warning center-block" role="button" >Itemniveau</a><br/>

						</div>
						<div class="modal-footer">
							<a class="btn btn primary" data-dismiss="modal">Sluiten</a>
						</div>
					</div>
				</div>

			</div>



			<!-- Jquery boven JavaScript anders error-->
			<script src="js/jquery.min.js"></script>
			<!-- Latest compiled and minified JavaScript -->
			<script src="js/bootstrap.min.js"></script>
		</body>
		</html>
