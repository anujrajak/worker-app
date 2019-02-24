<?php

require "../../config.php";

$conn = connection();

$category = $_POST['category'];


$check = "SELECT *  FROM `category` WHERE `catName` = '$category'";

$rs = mysqli_query($conn, $check);

if (mysqli_num_rows($rs) == 0) {
	mysqli_query($conn, "INSERT INTO `category` (`catId`, `catName`, `catStatus`) VALUES (NULL, '$category', '1')");
	echo "Category details inserted successfully...";
}else{
	echo "<span class='text-danger'>Category already exists...</span>";
}