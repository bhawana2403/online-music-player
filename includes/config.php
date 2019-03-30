<?php 
ob_start();
session_start();
$timezone=date_default_timezone_set("Asia/Kolkata");
//localhost: default server; root: default user
//Bydefault no password; slotify: database name
$con = mysqli_connect("localhost","root","","slotify");
//if failed to connect to database
if(mysqli_connect_errno()){
	echo "Failed to connect".mysqli_connect_errno();
}
?>