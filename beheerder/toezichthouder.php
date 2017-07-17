<?php 
session_start();
if(!isset($_SESSION['name'])){
	header('location: login.php');
}
include "../config.php";
include '../functions.php';
include '../header.php';
include '../nav.php';
?>
<link rel="stylesheet" href="../style.css">
<body>
<div class="container">
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