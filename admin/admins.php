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
<link rel="stylesheet" href="/style.css">
<body>
<div class="container">
	<div class="row">
		<div class="col-md-12">	
		<?php 		
			include "../adminform.php";
			if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) ){
				addAdminInfo($_POST['name'],$_POST['email'],$_POST['password']);
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
								<input type='text' class='form-control' name='name' value="<?php echo $st_row['name'] ?>"/>
							</div>
							<div class="col-md-2">
								<input type='text' class='form-control' name='email' value="<?php echo $st_row['email'] ?>"/>
							</div>
						</div>
						<div class="form-group">
							<input type='submit' value='Update' class='btn btn-primary'/>
						</div>
					</form>
				</div>
			</div>
			<?php } 
				if(isset($_POST['id'])&& isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['spots'])){	
					updateUserInfo($_POST['id'], $_POST['name'],$_POST['email'], $_POST['password'], $_POST['spots']);		
				}
		
		?>
			<div class="panel panel-default">
			  	<div class="panel-heading">
			  		Admin
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
						getAdminInfo('Admin');				
					?>
					</tbody> 
				</table>
				</div>
			</div>
		</div>
	</div>
</div>
</body>