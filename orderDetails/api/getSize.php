<?php

require "../../config.php";

$conn = connection();

$condition = "";

// if(isset($_POST['id']) && $_POST['id']!=""){
// 	$condition .=" AND proCat = '".$_POST['id']."'";
// }


$check = "SELECT * FROM `product` p INNER JOIN `size` s ON p.proSize = s.sizeId WHERE 1 $condition ORDER BY s.sizeName";

$rs = mysqli_query($conn, $check);

?>
<select class="form-control " id="sizeId" onchange="getPrice(this.value);">
	<option>Select Size</option>
	<?php foreach ($rs as $row) { ?>
		<option value="<?php echo $row['sizeId']; ?>"><?php echo ucwords($row['sizeName']); ?></option>
	<?php } ?>								
</select>