<?php 
session_start();
if(!isset($_SESSION['name'])){
	header('location: ../login.php');
} 
include '../config.php';
include '../functions.php';
include '../header.php';
include '../nav.php'
?>
<body>
<!-- Admin index --> 

<div class="container">
	<div class="row">
		<div class="col-md-12">
	
		<?php 		
		include "../form.php";
		if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['spots']) && isset($_POST['type']) ){
			addUserInfo($_POST['name'],$_POST['email'],$_POST['password'],$_POST['spots'],$_POST['type'], $_SESSION['city']);
		}

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
						<div class="col-md-2">
							<select id="type" class="form-control" name='type'><?php if($_SESSION['type']== 'Admin') { ?><option value="Beheerder">Beheerder</option><?php } ?><option value="Gebruiker">Gebruiker</option><option value="Toezichthouder">Toezichthouder</option></select>
						</div>
						<div class="col-md-2">
							<input type='text' class='form-control' name='name' value="<?php echo $st_row['name'] ?>"/>
						</div>
						<div class="col-md-2">
							<input type='text' class='form-control' name='email' value="<?php echo $st_row['email'] ?>"/>
						</div>
						<div class="col-md-2">
							<input type='text' class='form-control' name='spots' value="<?php echo $st_row['parking_spots'] ?>"/>
						</div>
					</div>
					<div class="form-group col-md-2">
						<input type='submit' value='Update' class='btn btn-primary addy'/>
					</div>
				</form>
			</div>
		</div>
		<?php } 
			if(isset($_POST['id'])&& isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['spots'])){	
				updateUserInfo($_POST['id'], $_POST['name'],$_POST['email'], $_POST['password'], $_POST['spots']);		
			}
		
		?>
			<!-- Huurders -->
			<div class="panel panel-default">
			  	<div class="panel-heading">
			  		Gebruikers 
				</div>	
				<div class="table-responsive">
				<table class="table table-striped table-hover"> 
					<thead> 
						<tr> 
							<th class="tableId">#</th> 
							<th class="tableName">Name</th> 
							<th class="tableEmail">Email</th> 
							<th class="tablePassword">Wachtwoord</th> 
							<th class="tableSpots">Plekken</th> 
							<th class="tableDelete"></th> 
						</tr> 
					</thead> 
					<tbody> 
					<?php 								
						getUserInfo('Gebruiker', $_SESSION['city']);				
					?>
					</tbody> 
				</table>
				</div>
			</div>
			<!-- Toezichthouders -->
			<div class="panel panel-default">
			  	<div class="panel-heading">
			  		Toezichthouders
				</div>	
				<div class="table-responsive">
				<table class="table table-striped table-hover"> 
					<thead> 
						<tr> 
							<th class="tableId">#</th> 
							<th class="tableName">Name</th> 
							<th class="tableEmail">Email</th> 
							<th class="tablePassword">Wachtwoord</th> 
							<th class="tableSpots"></th> 
							<th class="tableDelete"></th> 
						</tr> 
					</thead> 
					<tbody> 
					<?php 								
						getUserInfo('Toezichthouder', $_SESSION['city']);				
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