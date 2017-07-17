<?php 

$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_password = '38322549';
$mysql_db = 'Parkit';

$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);

if (!$mysqli){
	die("Connection failed:" . mysqli_connect_error());
} else {
	// echo "Connection yess";
}

							