<?php 

// print_r($_POST);

require "../config.php";
$conn = connection();

$date = date("F_j_Y_G_i_s");
$uid = uniqid($date);


$check = "INSERT INTO `billrecords` (`billId`, `billUid`, `workerId`, `billAmount`, `billDate`, `billRecDate`) VALUES (NULL, '".$uid."', '".$_POST['workerId']."', '".$_POST['total_amt']."', '".$_POST['delivery']."', '')";

if (mysqli_query($conn, $check)) {
	$count = $_POST['count'];
	for ($i=0; $i < $count; $i++) {

		$category = $_POST['categoryId_'.$i];
		// $size = $_POST['sizeId_'.$i];
		$price = $_POST['proPrice_'.$i];
		$qty = $_POST['proQty_'.$i];

		$proRS = mysqli_query($conn, "SELECT * FROM `workerproduct` WHERE `wpWorkerId` =". $_POST['workerId']);
		foreach ($proRS as $row) {}
		$pid = $row['wpProductId'];
		echo $sql = "INSERT INTO `billproducts` (`bpId`, `bpBid`, `bpPid`, `bpQty`, `bpPrice`) VALUES (NULL, '".$uid."', $pid, $qty, $price)";
		mysqli_query($conn, $sql);
	}
}

header('Location: index.php');
