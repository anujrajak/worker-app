<?php

function connection() {
	$servername = "localhost";
	$username = "root";
	$password = "";
	
	$conn = mysqli_connect($servername,$username,$password,"worker");

	return $conn;
}