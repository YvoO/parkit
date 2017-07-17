<?php 
session_start();
if(!isset($_SESSION['name'])){
	header('location: ../login.php');
} 
include '../config.php';
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
						mysqli_query($mysqli, $sql) or die ("Failed" .mysql_error());
					}

					if(isset($_GET['del2']))
					{ 
						$sql = "DELETE FROM login WHERE city='$stad' ";
						mysqli_query($mysqli, $sql) or die ("Failed" .mysql_error());
					}

					if(isset($_GET['del2']))
					{ 
						$sql = "DELETE FROM nummerborden WHERE plaats='$stad' ";
						mysqli_query($mysqli, $sql) or die ("Failed" .mysql_error());
						header('location: index.php'); 			
					}
				?>
		</div>
	</div>
</div> 
<div class="container">
	<div class="row">
		<div class="col-md-12">
		<?php 		
		include "../form.php";

		if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['spots']) && isset($_POST['type']) ){
			addUserInfo($_POST['name'],$_POST['email'],$_POST['password'],$_POST['spots'],$_POST['type'], $stad);
		}
		
		if(isset($_GET['edit'])) 
		{
			$id = $_GET['edit'];
			$sql = "SELECT * FROM login WHERE id='$id'";
			$query = mysqli_query($mysqli, $sql);
			$row = mysqli_fetch_array($query);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form method="post">
					<div class="form-group">
						<div class="col-md-0">
							<input type='hidden' class='form-control' name='id' value="<?php echo $row['id'] ?>"/>
						</div>
						<div class="col-md-2">
							<input type='text' class='form-control' name='name' value="<?php echo $row['name'] ?>"/>
						</div>
						<div class="col-md-2">
							<input type='text' class='form-control' name='email' value="<?php echo $row['email'] ?>"/>
						</div>
						<div class="col-md-2">
							<input type='text' class='form-control' name='spots' value="<?php echo $row['parking_spots'] ?>"/>
						</div>
					</div>
					<div class="form-group col-md-2">
						<input type='submit' value='Update' class='btn btn-primary addy'/>
					</div>
				</form>
			</div>
		</div>
		<?php } 
			if(isset($_POST['id'])&& isset($_POST['name']) && isset($_POST['email']) && isset($_POST['spots'])){	
				updateUserInfo($_POST['id'], $_POST['name'],$_POST['email'], $_POST['spots']);		
			}
		?>

		<!-- Beheerders -->
		<div class="panel panel-default">
			<div class="panel-heading">Beheerders</div>			
				<div class="table-responsive">
					<table class="table table-striped table-hover"> 
						<thead> 
							<tr> 
								<th class="table$-Id">#</th> 
							<th class="tableName">Name</th> 
							<th class="tableEmail">Email</th> 
							<th class="tablePassword">Wachtwoord</th> 
							<th class="tableSpots"></th> 
							<th class="tableDelete"></th> 
						</tr> 
					</thead> 
					<tbody> 
					<?php 								
						getUserInfo('Beheerder', $stad);		
					?>
					</tbody> 
				</table>
				</div>
			</div>

			<!-- Gebruikers -->
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
						getUserInfo('Gebruiker', $stad);				
					?>
					</tbody> 
				</table>
				</div>
			</div>
			<!-- Controlleurs -->
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
						getUserInfo('Toezichthouder', $stad);				
					?>
					</tbody> 
				</table>
				</div>
			</div>
		</div>
		<a onClick="return confirm('Weet u zeker dat u deze stad wilt verwijderen?')" <?php echo "href='gebruikers.php?city=$stad&del2=$stad' "?> class='col-md-12'><div class='redbtn'><h4>Verwijder</h4></div></a>
	</div>
</div>

</body>