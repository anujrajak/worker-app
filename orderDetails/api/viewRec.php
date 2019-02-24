<?php

require "../../config.php";
$conn = connection();

$bpid = $_POST['bpId'];
$recQry = "SELECT * FROM `receivedproducts` WHERE `RPBid` = $bpid ORDER BY `RPEntrydt` DESC";
$rs = mysqli_query($conn, $recQry);

?>

<!-- <div class="container-fluid"> -->
	<div class="table-responsive w-100">
		<table class="table table-bordered text-center">
			<thead class="text-center">
				<tr class="btn-danger">
					<th>
						#
					</th>
					<th>
						Received quantity
					</th>
					<th>
						Received date
					</th>
				</tr>
			</thead>
			<tbody>
				<?php $s=0; foreach ($rs as $row) { $s++; ?>
					<tr>
						<td><?php echo $s."."; ?></td>
						<td><?php echo $row['RPQty']; ?></td>
						<td><?php echo date("d-m-Y", strtotime($row['RPEntrydt'])); ?></td>
					</tr>
				<?php }	?>

			</tbody>