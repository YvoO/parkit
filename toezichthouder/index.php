<?php 
session_start();
if(!isset($_SESSION['name'])){
	header('location: login.php');
}
include "../config.php";
include '../functions.php';
include '../header.php';
include '../nav.php';
userTypeGebruiker('Toezichthouder');
?>
<link rel="stylesheet" href="../style.css">

<body>
<!-- Toezichthouder index -->
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
		<div class="col-md-12">
			<div class="panel panel-default">
			  	<div class="panel-heading">Nummerborden</div>
			  	<div class="table-responsive">
					<table class="table table-striped table-hover table-responsive"> 
						<thead> 
							<tr> 
								<th class="tableId">#</th> 
								<th class="tablePlate">Nummerbord</th>
								<th class="tableName">Aangemeld door</th>
								<th class="tableNote">Opmerking</th>
							</tr> 
						</thead> 
						<tbody> 
							<?php 								
								getNumberPlates($_SESSION['city']);
							?>
						</tbody> 
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>	