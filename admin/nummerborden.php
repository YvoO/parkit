<?php 
session_start();
if(!isset($_SESSION['name'])){
	header('location: login.php');
}
include "../config.php";
include '../functions.php';
include '../header.php';
include '../nav.php';
userTypeGebruiker('Admin');
?>
<link rel="stylesheet" href="../style.css">

<body>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="jumbotron">
				<h1>
				<?php 
					$GLOBALS['stad'] = $_GET['city'];
					echo $stad;
				?>
				</h1>
			</div>
		</div>
		<div class="col-md-4">
				<a href='/admin/gebruikers.php? <?php echo "city=$stad" ?>' class='col-md-12' style='margin-top: -10px;'><div class='submenu'><h4>Gebruikers</h4></div></a>
				<a href='/admin/nummerborden.php?<?php echo "city=$stad" ?>' class='col-md-12'><div class='submenu'><h4>Nummerborden</h4></div></a>
				<a href='/logboek.php?<?php echo "city=$stad" ?>' class='col-md-12'><div class='submenu'><h4>Logboek</h4></div></a>
				
				<?php
					if(isset($_GET['del2']))
					{ 
						$sql = "DELETE FROM plaatsen WHERE plaats='$stad' ";
						$res= mysql_query($sql) or die ("Failed" .mysql_error());
					}

					if(isset($_GET['del2']))
					{ 
						$sql = "DELETE FROM login WHERE city='$stad' ";
						$res= mysql_query($sql) or die ("Failed" .mysql_error());
					}

					if(isset($_GET['del2']))
					{ 
						$sql = "DELETE FROM nummerborden WHERE plaats='$stad' ";
						$res= mysql_query($sql) or die ("Failed" .mysql_error());
						header('location: index.php'); 			
					}
				?>
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
								getNumberPlates($stad);
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