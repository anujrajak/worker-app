<?php

require "../../config.php";

$conn = connection();

$wid = $_POST['workerId'];
$pid = $_POST['productId'];

$check = "SELECT * FROM `workerproduct` WHERE `wpWorkerId` = $wid AND `wpProductId` = $pid";

$rs = mysqli_query($conn, $check);

foreach ($rs as $row) { ?>
	<input type="number" class="form-control" id="price" placeholder="Enter price" value="<?php echo $row['wpProPrice']; ?>" disabled>
<?php } ?>