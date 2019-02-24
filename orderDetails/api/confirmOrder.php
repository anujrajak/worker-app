<?php

require "../../config.php";
$conn = connection();

$now = date("Y-m-d");

$check = "UPDATE billrecords SET billStatus = 2 , billRecDate = '".$now."' WHERE billId = ". $_POST['id'];
mysqli_query($conn, $check);
