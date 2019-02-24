<?php

require "../../config.php";
$conn = connection();

$billId = $_POST['id'];

$billRec = "SELECT * FROM `billrecords` b INNER JOIN worker w ON w.id=b.workerId WHERE `billId` = $billId";
$billRec = mysqli_query($conn, $billRec);
foreach ($billRec as $row) {}

$proRec = "SELECT * FROM `billproducts` bp INNER JOIN billrecords br ON br.billUid=bp.bpBid INNER JOIN workerproduct wp ON wp.wpProductId = bp.bpPid INNER JOIN product p ON p.proId = wp.wpProductId INNER JOIN category c ON c.catId=p.proCat INNER JOIN size s ON s.sizeId = p.proSize WHERE bp.bpBid ='". $row['billUid'] ."'";

$proRecs = mysqli_query($conn, $proRec);
// print_r($proRecs);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Worker Admin</title>
	<!-- plugins:css -->
	<link rel="stylesheet" href="../../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
	<!-- endinject -->
	<!-- inject:css -->
	<link rel="stylesheet" href="../../css/boot.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/custom.css">

	<!-- endinject -->
	<link rel="shortcut icon" href="../../images/favicon.png" />
</head>
<body>

		<div class="container-fluid">
			<h3 class="text-right my-5">Invoice&nbsp;&nbsp;#<?php echo $row['billId'] ;?></h3>
			<hr>
		</div>
		<div class="container-fluid d-flex justify-content-between">
			<div class="col-lg-3 pl-0">
				<p class="mt-5 mb-2"><b>VSK INDUSTRIES</b></p>
				<p>Order Date: <b><?php echo date("d-m-Y", strtotime($row['billDate'])); ?></b><br>Receive Date: <b><?php echo date("d-m-Y", strtotime($row['billRecDate'])); ?></b></p>
			</div>
			<div class="col-lg-3 pr-0">
				<p class="mt-5 mb-2 text-right"><b>Invoice to</b></p>
				<p class="text-right">Name:&nbsp;<?php echo ucwords($row['name']) ?>,<br> Mobile:&nbsp;<?php echo ucwords($row['mobile']) ?></p>
			</div>
		</div>
		<div class="container-fluid">
			<div class="table-responsive w-100">
				<table class="table table-bordered">
					<thead>
						<tr class="btn-danger">
							<th>
								#
							</th>
							<th>
								Product
							</th>
							<th>
								Price
							</th>
							<th>
								Quantity
							</th>
							<th>
								Total
							</th>
						</tr>
					</thead>
					<tbody>
						<?php $s=0; foreach ($proRecs as $pro) { $s++; ?>
							<tr>
								<td><?php echo $s; ?></td>
								<td><?php echo ucwords($pro['catName']." : ".$pro['sizeName']); ?></td>
								<td><?php echo $pro['bpPrice']." &#8377;" ?></td>
								<td><?php echo $pro['bpQty'] ?></td>
								<td><?php echo $pro['bpPrice'] * $pro['bpQty']." &#8377;" ?></td>

							</tr>							
						<?php } ?>
						<tr>
							<td colspan="4"></td>
							<td><h4 class="text-right">Total : <?php echo $row['billAmount']." &#8377;" ?></h4></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="container-fluid row w-100">
			<a href="#" class="btn btn-primary  mt-4 ml-2"><i class="mdi mdi-printer mr-1"></i>Print</a>&nbsp;
			<button class="btn btn-success mt-4" data-dismiss="modal">Cancel</button>
		</div>

	<script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>
	<!-- plugins:js -->
	<script src="../vendors/js/vendor.bundle.base.js"></script>
	<script src="../vendors/js/vendor.bundle.addons.js"></script>
	<!-- endinject -->
	<!-- Plugin js for this page-->
	<!-- End plugin js for this page-->
	<!-- inject:js -->
	<script src="../js/off-canvas.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/misc.js"></script>
	<!-- endinject -->
	<!-- Custom js for this page-->
	<script src="../js/dashboard.js"></script>
	<script src="../js/jquery.js"></script>
	<!-- End custom js for this page-->

	<!-- Insert this line after script imports -->
	<script>if (window.module) module = window.module;</script>
</body>

</html>