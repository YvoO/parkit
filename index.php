<?php 
session_start();
if(!isset($_SESSION['type'])){
	header('location: login.php');
} 

include 'config.php';
include 'functions.php';
include 'header.php';
include 'nav.php';

userTypeGebruiker('Gebruiker');

?>
<link rel="stylesheet" href="/style.css">

<body>
<!-- Gebruiker index --> 
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="jumbotron">
				<h1>Hallo, <?php echo $_SESSION['name']; ?>!</h1>
			</div>
		</div>
	</div>
</div> 
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-body" style="background-color: #f5f5f5;">
					<?php 
						if(isset($_POST['number_plate']) && isset($_POST['note'])){
							addNumberPlate(strtoupper($_POST['number_plate']), mysql_real_escape_string($_POST['note']));
						}?>
					<form method="post">
						<div class="form-group">
						  	<div class="alert alert-warning" role="alert" style="margin: 10px 0 10px 0;">Gebruiker is verantwoordelijk voor juiste invoer</div>
							<h4 style="float:left; display:inline;">Nummerbord</h4>
						  	<h4 style="float:right; display:inline;"><?php numberOfPlates($_SESSION['id']); ?> </h4>
							<input type='text' class='form-control' name='number_plate' placeholder='Nummerbord' id='numberInput'style="margin: 0 0 10px 0;"/>
							<input type='text' class='form-control' name='note' placeholder='Opmerking' id='noteInput'/>
						</div>
						<input type='submit' value='Voeg toe' class='btn btn-primary'/>
					</form>
				</div>
			</div>	
		</div>
		<div class='col-md-8'>
			<div class="panel panel-default">
  			<!-- Default panel contents -->
			 	<div class="panel-heading">
			  		Overzicht 
			  	</div>		
			  	<div class="table-responsive">
					<table class="table table-striped table-hover table-responsive"> 
						<thead> 
							<tr> 
								<th class="tableId">#</th> 
								<th class="tablePlate">Nummerbord</th>
								<th class="tableNote">Opmerking</th>
								<th class="tableDelete"></th>
							</tr> 
						</thead> 
						<tbody> 
							<?php 			
								GetPersonalNumberplates($_SESSION['id']);
							?>
							</tbody> 
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>