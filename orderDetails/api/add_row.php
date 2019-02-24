<?php

require "../../config.php";

$conn = connection();

$pid = $_POST['productId'];
$wid = $_POST['workerId'];

$check = "SELECT * FROM `workerproduct` wp INNER JOIN product p ON p.proId=wp.wpProductId INNER JOIN category c ON p.proCat = c.catId INNER JOIN size s ON s.sizeId = p.proSize WHERE wpWorkerId = $wid AND wpProductId = $pid";

$rs = mysqli_query($conn, $check);

foreach ($rs as $row) {}
	
?>
	<td>
		<?php echo $_POST['count']+1; ?>
	</td>
	<td>
		<select class="form-control " name="categoryId_<?php echo $_POST['count']; ?>">
			<option>Select Product</option>
			<option value="<?php echo $row['wpProductId']; ?>" selected><?php echo ucwords($row['catName']." : ".$row['sizeName']); ?></option>
		</select>
	</td>
	<!-- <td>
		<select class="form-control " name="sizeId_<?php echo $_POST['count']; ?>">
				<option>Select size</option>
				<option value="<?php echo $row['proSize']; ?>" selected><?php echo ucwords($row['sizeName']); ?></option>
		</select>
	</td> -->
	<td style="width: 15%;">
		<input type="number" class="form-control" name="proPrice_<?php echo $_POST['count'] ?>" id="proPrice_<?php echo $_POST['count'] ?>" value="<?php echo $row['wpProPrice']; ?>">		
	</td>
	<td style="width: 15%;">
		<input type="number" class="form-control" min="1" name="proQty_<?php echo $_POST['count'] ?>" id="proQty_<?php echo $_POST['count'] ?>" value="<?php echo $_POST['qty']; ?>" onkeyup="calc(this.value, this.id);">
	</td>
	<td style="width: 15%;">
		<input type="number" class="form-control" name="total_<?php echo $_POST['count'] ?>" id="total_<?php echo $_POST['count'] ?>" value="<?php echo $row['wpProPrice'] * $_POST['qty']; ?>">
	</td>
