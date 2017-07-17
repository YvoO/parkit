<?php 
session_start();
if(!isset($_SESSION['name'])){
	header('location: ../login.php');
} 
require '../config.php';
include '../functions.php';
include '../header.php';
include '../nav.php';
userTypeGebruiker('Admin');
?>
<link rel="stylesheet" href="../style.css">
<body>
<!-- Admin index --> 

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
			<?php 
			if(isset($_POST['voeg']) ){
				include '../parkeerform.php';
			}
			
			if(isset($_POST['plaats']) && isset($_POST['straat']) && isset($_POST['postcode'])){
				addPlace($_POST['plaats'],$_POST['straat'],$_POST['postcode']);
			}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">	
			<div class="row">
				<?php 
					getLocations();
				?>
				<form method='post' class='col-md-3 col-xs-12'>
					<input type='submit' name='voeg' value='toevoegen' class='btn btn-succes steden' style="width: 100%;"/>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>	