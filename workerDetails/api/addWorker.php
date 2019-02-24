<?php

require "../../config.php";

$conn = connection();

$name = $_POST['name'];
$mobile = $_POST['mobile'];

$check = "SELECT *  FROM `worker` WHERE `name` = '$name' AND `mobile` = '$mobile' ";

$rs = mysqli_query($conn, $check);

if (mysqli_num_rows($rs) == 0) {
	mysqli_query($conn, "INSERT INTO `worker` (`id`, `name`, `mobile`, `status`) VALUES (NULL, '$name', '$mobile', '1')");
	echo "Worker details inserted successfully...";
}else{
	echo "<span class='text-danger'>Worker already exists...</span>";
}