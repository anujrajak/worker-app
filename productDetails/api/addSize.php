<?php

require "../../config.php";

$conn = connection();

$size = $_POST['size'];


$check = "SELECT *  FROM `size` WHERE `sizeName` = '$size'";

$rs = mysqli_query($conn, $check);

if (mysqli_num_rows($rs) == 0) {
	mysqli_query($conn, "INSERT INTO `size` (`sizeId`, `sizeName`, `sizeStatus`) VALUES (NULL, '$size', '1')");
	echo "Size details inserted successfully...";
}else{
	echo "<span class='text-danger'>Size already exists...</span>";
}