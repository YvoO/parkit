<?php

function userTypeGebruiker($userType){
	if( ($_SESSION['type']) !== $userType){
		
		if( ($_SESSION['type']) == "Admin"){
			header('location: ../admin/index.php');
		} 
		elseif (($_SESSION['type']) == "Toezichthouder"){
			header('location: ../toezichthouder/index.php');
		}
		elseif (($_SESSION['type']) == "Beheerder"){
			header('location: ../beheerder/index.php');
		}
		elseif (($_SESSION['type']) == "Gebruiker"){
			header('location: ../index.php');
		}
	} 
}

function addNumberPlate($numberPlate, $note){
	require "config.php";
	$user_id = $_SESSION['id'];
	$name = $_SESSION['name'];
	$city = $_SESSION['city'];
	$date = date('d.m.Y H:i:s');


	$sql = "INSERT INTO nummerborden (numberplate, note, user_id, name, plaats) VALUES ('$numberPlate','$note', '$user_id', '$name', '$city')";

	if(mysqli_query($mysqli, $sql))
	{ ?>
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Nummerbord toegevoegd!</strong>
		</div> <?php	
	}
	else 
	{ ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Dit nummerbord is al aangemeld!</strong>
		</div> <?php		
	}

	$sql2 = "SELECT * FROM `nummerborden` WHERE `numberplate` = '$numberPlate' ";
	$query2 = mysqli_query($mysqli, $sql2);
	$row = mysqli_fetch_assoc($query2);
	$number_id = $row['id'];
	
	$sql3 = "INSERT INTO logboek (numberplate, user_id, number_id, plaats, arrival) VALUES ('$numberPlate', '$user_id', '$number_id', '$city', '$date')";
	mysqli_query($mysqli, $sql3);
}

function GetPersonalNumberplates($user_id) {
	require "config.php";
	$sql = "SELECT `parking_spots` FROM `login` WHERE `id` = ".$user_id." ";
	$query = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($query);
	$totalNumberOfSpots = $row['parking_spots'];	
	$occupiedNumberOfSpots = 0;
	$i=1;
			
	if($totalNumberOfSpots == 0)
	{	?> 
		<script> 
			document.getElementById('numberInput').disabled = true;
			document.getElementById('noteInput').disabled = true;
		</script>  <?php
	} 

	$sql2 = "SELECT * FROM `nummerborden` WHERE `user_id` = ".$user_id." ORDER BY numberplate ";
	$query2 = mysqli_query($mysqli, $sql2);

	while ($row = mysqli_fetch_assoc($query2)){
		echo "<tr><th>".$i."</th><th>"."<div class='nummerplaat'>".$row['numberplate']."</div>"."</th><th>".$row['note']."</th><th><a href='?del=$row[id]&num=$row[numberplate]'>Afmelden</a></th></tr>";
		$i++;
		$occupiedNumberOfSpots++;
		
		if($occupiedNumberOfSpots == $totalNumberOfSpots) 
		{	?> 
			<script>
				document.getElementById('numberInput').disabled = true;
				document.getElementById('noteInput').disabled = true;
				document.getElementById('spaces').innerHTML = "Geen plekken meer beschikbaar";
			</script>  <?php
		}
	}	

	$user_id = $_SESSION['id'];
	$name = $_SESSION['name'];
	$city = $_SESSION['city'];
	$date = date('d.m.Y H:i:s');

	if(isset($_GET['del'])){
		$id = $_GET['del'];
		$numberPlate = $_GET['num'];
		$sql = "DELETE FROM nummerborden WHERE id='$id' ";

		$sql2 = "UPDATE logboek SET departure = '$date' WHERE numberplate='$numberPlate' ";
		mysqli_query($mysqli, $sql2);

		$res = mysqli_query($mysqli, $sql) or die ("Failed" .mysql_error());
		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	}		
}	

function getLogboekGebruiker($type, $user_id, $stad) {
	require "config.php";
	$i = 1;

	if($type == 'Gebruiker')
	{	
		$sql = "SELECT * FROM logboek WHERE `user_id` = $user_id ORDER BY departure DESC ";
		$query = mysqli_query($mysqli, $sql);
		while ($row = mysqli_fetch_assoc($query)){
			echo "<tr><th>".$i."</th><th>"."<div class='nummerplaat'>".$row['numberplate']."</div>"."</th><th>".$row['arrival']."</th><th>".$row['departure']."</th></tr>";
			$i++;
		}
	} 
	elseif($type =='Beheerder' or $type =='Admin' or $type == 'Toezichthouder' )
	{
		$sql = "SELECT * FROM logboek WHERE `plaats` = '$stad' ORDER BY departure DESC";
		$query = mysqli_query($mysqli, $sql);
		while ($row = mysqli_fetch_assoc($query)){
			echo "<tr><th>".$i."</th><th>"."<div class='nummerplaat'>".$row['numberplate']."</div>"."</th><th>".$row['arrival']."</th><th>".$row['departure']."</th></tr>";
			$i++;
		}
	}
}

function numberOfPlates($user_id) {
	require "config.php";
	$sql = "SELECT `parking_spots` FROM `login` WHERE `id` = ".$user_id." ";
	$query = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($query);
	$totalNumberOfSpots = $row['parking_spots'];	
	$occupiedNumberOfSpots = 0;
	$i=1;

	$sql2 = "SELECT * FROM `nummerborden` WHERE `user_id` = ".$user_id." ORDER BY numberplate ";
	$query2 = mysqli_query($mysqli, $sql2);
	while ($row = mysqli_fetch_assoc($query2)){
		$occupiedNumberOfSpots++;
	}	

	echo $occupiedNumberOfSpots . '/' . $totalNumberOfSpots;
}

function getNumberplates($city){
	require "config.php";
	$i=1;
		$sql = "SELECT numberplate, name, note FROM nummerborden WHERE plaats = '$city' ORDER BY numberplate";
		$query = mysqli_query($mysqli, $sql);
		while ($row = mysqli_fetch_assoc($query)){
			echo "<tr><th>".$i."</th><th>"."<div class='nummerplaat'>".$row['numberplate']."</div>"."</th><th>".$row['name']."</th><th>".$row['note']."</th></tr>";
		$i++;
		}
}

function addAdminInfo($name,$email,$password){
	require "config.php";
	$name = $mysqli->real_escape_string($_POST['name']);
	$email = strtolower($_POST['email']);
	$password = $_POST['password'];
	$type = 'Admin';
	$city = 'Admin';

	$sql = "INSERT INTO login (`name`,`email`,`password`, `type`, `city`) VALUES ('$name','$email','$password', '$type', '$city')";
	if(mysqli_query($mysqli, $sql)) { ?>
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>New person added!</strong>
		</div> <?php
	} else { ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Something went wrong!</strong>
		</div> <?php	
	}
}

function addUserInfo($name,$email,$password,$spots,$type, $city){
	require "config.php";
	$name = $mysqli->real_escape_string($_POST['name']);
	$email = strtolower($_POST['email']);
	$password = $_POST['password'];
	$spots = $_POST['spots'];
	$type = $_POST['type'];

	$sql = "INSERT INTO login (`name`,`email`,`password`, `parking_spots`, `type`, `city`) VALUES ('$name','$email','$password','$spots', '$type', '$city')";
	if(mysqli_query($mysqli, $sql)) { ?>
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>New person added!</strong>
		</div> <?php
	} else { ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Something went wrong!</strong>
		</div> <?php	
	}
}

function updateUserInfo($id, $name, $email, $spots){
	require "config.php";
	$id = $_POST['id'];
	$name = $mysqli->real_escape_string($_POST['name']);
	$email = strtolower($_POST['email']);
	$spots = $_POST['spots'];

	$sql = "UPDATE login SET id='$id', name='$name', email='$email', parking_spots='$spots' WHERE id='$id' ";
	if(mysqli_query($mysqli, $sql)) { 
		$stad = $_GET['city'];
		echo '<meta http-equiv="refresh" content="0; url=gebruikers.php?city='.$stad.'">';
	} 
	else { 
		echo "Something went wrong!";
	}
}

function getUserInfo($type, $stad) {
	require "config.php";
	$i=1;					
	$sql ="SELECT * FROM `login` WHERE `type` = '$type' AND city = '$stad' ORDER BY name";	
	$query = mysqli_query($mysqli, $sql);

	if($type=='Gebruiker')
	{
		while ($row = mysqli_fetch_assoc($query)){
		echo "<tr><th>".$i."</th><th>".$row['name']."</th><th>".$row['email']."</th><th>".$row['password']."</th><th>".$row['parking_spots']."</th><th><a href='?city=$stad&edit=$row[id]'>Bewerken </a>"." | "."<a href='?city=$stad&del=$row[id]'> Verwijder</a></th></tr>";
		$i++;
		}
	} else 
	{
		while ($row = mysqli_fetch_assoc($query)){
		echo "<tr><th>".$i."</th><th>".$row['name']."</th><th>".$row['email']."</th><th>".$row['password']."</th><th>".""."</th><th><a href='?city=$stad&edit=$row[id]'>Bewerken </a>"." | "."<a href='?city=$stad&del=$row[id]'> Verwijder</a></th></tr>";
		$i++;
		}
	}

	if(isset($_GET['del']))
	{
		$id = $_GET['del'];
		$sql = "DELETE FROM login WHERE id='$id' ";
		mysqli_query($mysqli, $sql) or die ("Failed" .mysql_error());
	}

	if(isset($_GET['del']))
	{
		$id = $_GET['del'];
		$sql = "DELETE FROM nummerborden WHERE user_id='$id' ";
		mysqli_query($mysqli, $sql) or die ("Failed" .mysql_error());
		echo '<meta http-equiv="refresh" content="0; url=gebruikers.php?city='.$stad.'">';
	}
}	

function getAdminInfo($type) {
	require 'config.php';
	$i=1;					
	$sql = "SELECT * FROM `login` WHERE `type` = '$type' ORDER BY name";	
	$query = mysqli_query($mysqli,$sql);

	while ($row = mysqli_fetch_assoc($query)){
		echo "<tr><th>".$i."</th><th>".$row['name']."</th><th>".$row['email']."</th><th>".$row['password']."</th><th>".""."</th><th><a href='?edit=$row[id]'>Bewerken </a>"." | "."<a href='?del=$row[id]'> Verwijder</a></th></tr>";
		$i++;
	}

	if(isset($_GET['del']))
	{
		$id = $_GET['del'];
		$sql = "DELETE FROM login WHERE id='$id' ";
		$res= mysqli_query($mysqli, $sql) or die ("Failed" .mysql_error());
	}

	if(isset($_GET['del']))
	{
		$id = $_GET['del'];
		$sql = "DELETE FROM nummerborden WHERE user_id='$id' ";
		$res= mysqli_query($mysqli,$sql) or die ("Failed" .mysql_error());
		echo '<meta http-equiv="refresh" content="0; url=admins.php">';
	}
}

function addPlace($plaats, $straat, $postcode){
	require 'config.php';
	$plaats = $_POST['plaats'];
	$straat = $_POST['straat'];
	$postcode = $_POST['postcode'];

	$sql = "INSERT INTO plaatsen (`plaats`,`straat`,`postcode`) VALUES ('$plaats','$straat','$postcode')";
	if(mysqli_query($mysqli, $sql)) { ?>
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>New postcode added!</strong>
		</div> <?php
	} else { ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Something went wrong!</strong>
		</div> <?php	
	}
}

function getLocations() {
	require 'config.php';
	$sql = "SELECT DISTINCT `plaats` FROM `plaatsen` ORDER BY `plaats` ";
	$query = mysqli_query($mysqli,$sql);
	while ($row = mysqli_fetch_assoc($query)){
		$city = $row['plaats'];
		echo "<a href='gebruikers.php?city=$row[plaats]' class='col-md-3'>"."<div class='steden'>"."<h4>".$row['plaats']."</h4>"."</div>"."</a>";
	}
} 

?>