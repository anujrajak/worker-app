<?php 

require "../../config.php";
$conn = connection();

$productDetails = mysqli_query($conn, "SELECT * FROM `workerproduct` wp INNER JOIN product p ON p.proId=wp.wpProductId INNER JOIN category c ON p.proCat = c.catId INNER JOIN size s ON s.sizeId = p.proSize WHERE wpWorkerId =".$_POST['workerId'] );

?>

<label for="name">Product :</label>
<select class="form-control " id="productId" onchange="getPrice()">
	<option>Select Product</option>
	<?php foreach ($productDetails as $row) { ?>
		<option value="<?php echo $row['wpProductId']; ?>"><?php echo ucwords($row['catName']." : ".$row['sizeName']); ?></option>
	<?php } ?>								
</select>
