<?php 
include 'config.php';
include 'header.php';
include 'functions.php';
?>
<body>
	<p><br/><br/><br/><br/><br/><br/><br/><br/><br/></p>
	<div class="container">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="panel panel-default login">
					<div class="panel-body">
						<?php 
						if(isset($_POST['username']) && isset($_POST['password'])){
							$username = strtolower($_POST['username']);
							$password = $_POST['password'];
							
							$stmt = $mysqli->prepare("SELECT * FROM login WHERE email= ? AND password= ? ");
							$stmt->bind_param("ss", $username, $password);
							$stmt->execute(); 
							$stmt->bind_result($id, $email, $name, $spots, $pass, $city, $type);
							$stmt->fetch();

							if($username == $email){
								if($password==$pass){
									session_start();
									$_SESSION['email'] = $email;
									$_SESSION['name'] = $name;
									$_SESSION['password'] = $password;
									$_SESSION['city'] = $city;
									$_SESSION['id'] = $id;
									$_SESSION['type'] = $type;
									$_SESSION['spots'] = $spots;
									if($type == 'Admin') {
									?> <script> window.location.href = 'admin/index.php'</script> <?php
									} elseif($type == 'Beheerder') {
										?> <script> window.location.href = 'beheerder/index.php'</script> <?php
									} elseif($type == 'Toezichthouder') {
										?> <script> window.location.href = 'toezichthouder/index.php'</script> <?php
									} else {
										?> <script> window.location.href = 'index.php'</script> <?php
									}

								}else {
								?><div class="alert alert-danger alert-dismissible" role="alert">
							  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Verkeerd wachtwoord
								</div>	<?php	
								}
							} else {
							?><div class="alert alert-danger alert-dismissible" role="alert">
							  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Onbekende gebruiker
								</div>	<?php
							}

						}
						?>
						<form method="post">
							<div class="form-group">
								<input type='text' class='form-control' placeholder='e-mail adres' name='username'/>
							</div>
							<div class="form-group">
								<input type='password' class='form-control' placeholder='Wachtwoord' name='password'/>
							</div>
							<input type='submit' value='Login' class='btn btn-primary addy'/>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
</body>