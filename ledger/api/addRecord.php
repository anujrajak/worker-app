<?php

require "../../config.php";

$conn = connection();

$name = $_POST['name'];
$amount = $_POST['amount'];
$note = $_POST['note'];
$date = $_POST['date'];

$rs = mysqli_query($conn, "INSERT INTO `ledger` (`ledgerId`, `ledgerWorkerId`, `ledgerAmt` , `ledgerNote`, `ledgerEntryDt`) VALUES (NULL, '$name', '$amount', '$note', '$date')");

if ($rs) {
	echo "Record inserted successfully";
}

// header('Location: index.php');