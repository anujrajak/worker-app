<?php

require "../../config.php";

$conn = connection();

// print_r($_POST);

$bpid = $_POST['bpId'];
$recQty = $_POST['recQty'];
$recDate = $_POST['recDate'];

$recQry = "INSERT INTO `receivedproducts` (`RPId`, `RPBid`, `RPQty`, `RPEntrydt`) VALUES (NULL, '$bpid', '$recQty', '$recDate')";
mysqli_query($conn, $recQry);

$check = "SELECT bpRQty FROM `billproducts` WHERE `bpId` = '$bpid'";
$rs = mysqli_query($conn, $check);

foreach ($rs as $row) {}

$qty =  $row['bpRQty'] + $recQty;

$upd = "UPDATE `billproducts` SET `bpRQty` = '$qty' WHERE `billproducts`.`bpId` = $bpid";
mysqli_query($conn, $upd);

echo "<span class=\"text-success\">Product received successfully...</span>";
?>