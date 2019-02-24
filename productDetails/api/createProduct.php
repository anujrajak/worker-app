<?php

require "../../config.php";

$conn = connection();

$proCategory = $_POST['proCategory'];
$proSize = $_POST['proSize'];
// $proPrice = $_POST['proPrice'];

$check = "SELECT * FROM product WHERE proCat = $proCategory AND proSize = $proSize";

$rs = mysqli_query($conn, $check);
// echo(mysqli_num_rows($rs));
// die();

if (mysqli_num_rows($rs) == 0) {
	mysqli_query($conn, "INSERT INTO `product` (`proId`, `proCat`, `proSize`) VALUES (NULL, '$proCategory', '$proSize')");
	echo "Product details inserted successfully...";
}else{
	echo "<span class='text-danger'>Product already exists...</span>";
}