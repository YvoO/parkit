<?php 
session_start();
if(!isset($_SESSION['name'])){
	header('location: /login.php');
} 
include 'config.php';
include 'functions.php';
include 'header.php';
include 'nav.php';
?>
<link rel="stylesheet" href="/style.css">
<!-- Naam, email adres type  -->


<!-- Profiel  -->
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="panel panel-default">
  			<!-- Default panel contents -->
			 	<div class="panel-heading">
			  		Profiel 
			  	</div>		
			  	<div class="table-responsive">
					<table class="table table-striped table-hover table-responsive"> 
						<thead> 
						</thead> 
						<tbody> 
							<tr><th>Naam:</th><th><?php echo $_SESSION['name'];?></th><th></th></tr>
							<tr><th>Email:</th><th><?php echo $_SESSION['email'];?></th><th></th></tr>
							<tr><th>Type:</th><th><?php echo $_SESSION['type'];?></th><th></th></tr>
							<tr><th>Wachtwoord:</th><th>********</th><th><a href='?edit=<?php  echo $_SESSION['id']; ?>'>Bewerken </a></th></tr>
							<tr><th>Plekken:</th><th><?php echo $_SESSION['spots'];?></th><th></th></tr>
						</tbody> 
					</table>
				</div>
			</div>

		<?php
		if(isset($_GET['edit'])) 
		{
			$id = $_GET['edit'];
			$row = mysql_query("SELECT * FROM login WHERE id='$id'");
			$st_row = mysql_fetch_array($row);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form method="post">
					<div class="form-group">
						<div class="col-md-0">
							<input type='hidden' class='form-control' name='id' value="<?php echo $st_row['id'] ?>"/>
						</div>
						<div class="col-md-4">
							<input type='password' class='form-control' name='password' placeholder="nieuw wachtwoord"/>
						</div>
						<div class="col-md-4">
							<input type='password' class='form-control' name='password2' placeholder="nogmaals"/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type='submit' value='Update' class='btn btn-primary addy'/>
					</div>
				</form>
			</div>
		</div>
		<?php } 
			if(isset($_POST['id']) && isset($_POST['password']) && isset($_POST['password2'])){
				
				if($_POST['password'] == $_POST['password2']) {					
						$id = $_POST['id'];
						$password = $_POST['password'];
						$sql = "UPDATE login SET password='$password' WHERE id='$id' ";
						
						if(mysql_query($sql)) { 
							echo '<meta http-equiv="refresh" content="0; url=profiel.php ">';
						} 
						else { 
							echo "Something went wrong!";
						}
				}
				else 
				{ ?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Wachtwoorden komen niet overeen!</strong>
					</div> <?php	
				}				

			}
		?>
		</div>
	</div>
</div> 

