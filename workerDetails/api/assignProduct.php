<?php
require "../../config.php";
$conn = connection();

$check = "SELECT * FROM `workerproduct` WHERE `wpWorkerId` = ".$_POST['workerId']." AND `wpProductId` = ". $_POST['productId'];
$rs = mysqli_query($conn, $check);

if (mysqli_num_rows($rs) == 0) {
	mysqli_query($conn, "INSERT INTO `workerproduct` (`wpId`, `wpWorkerId`, `wpProductId`, `wpProPrice`, `wpStatus`) VALUES (NULL, '".$_POST['workerId']."', '".$_POST['productId']."', '".$_POST['proPrice']."','1');");
	$productList = mysqli_query($conn, "SELECT * FROM `workerproduct` wp INNER JOIN product p ON p.proId=wp.wpProductId INNER JOIN category c ON p.proCat = c.catId INNER JOIN size s ON s.sizeId = p.proSize WHERE wpWorkerId =".$_POST['workerId'] );
	echo "<span class='text-success'>Product details added successfully...</span>";
	?>
		<table class="table table-hover table-bordered">
			<thead class="bg-gradient-primary text-white">
				<tr>
					<th>#</th>
					<th>Product Name</th>
					<th>Price</th>                        
				</tr>
			</thead>
			<tbody>
				<?php $s=0; foreach ($productList as $value) { $s++; ?>
					<tr>
						<td><?php echo $s; ?></td>
						<td><?php echo ucwords($value['catName']." : ".$value['sizeName']); ?></td>
						<td><?php echo $value['wpProPrice']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php
}else{
	$productList = mysqli_query($conn, "SELECT * FROM `workerproduct` wp INNER JOIN product p ON p.proId=wp.wpProductId INNER JOIN category c ON p.proCat = c.catId INNER JOIN size s ON s.sizeId = p.proSize WHERE wpWorkerId =".$_POST['workerId'] );
	echo "<span class='text-danger'>Product already assigned...</span>";
	?>
		<table class="table table-hover table-bordered">
			<thead class="bg-gradient-primary text-white">
				<tr>
					<th>#</th>
					<th>Product Name</th>
					<th>Price</th>                        
				</tr>
			</thead>
			<tbody>
				<?php $s=0; foreach ($productList as $value) { $s++; ?>
					<tr>
						<td><?php echo $s; ?></td>
						<td><?php echo ucwords($value['catName']." : ".$value['sizeName']); ?></td>
						<td><?php echo $value['wpProPrice']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php
}