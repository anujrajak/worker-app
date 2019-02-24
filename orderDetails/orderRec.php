<?php

require "../config.php";
$conn = connection();

$billId = $_POST['billId'];

$billRec = "SELECT * FROM `billrecords` b INNER JOIN worker w ON w.id=b.workerId WHERE `billId` = $billId";
$billRec = mysqli_query($conn, $billRec);
foreach ($billRec as $row) {}

$proRec = "SELECT * FROM `billproducts` bp INNER JOIN billrecords br ON br.billUid=bp.bpBid INNER JOIN workerproduct wp ON wp.wpProductId = bp.bpPid INNER JOIN product p ON p.proId = wp.wpProductId INNER JOIN category c ON c.catId=p.proCat INNER JOIN size s ON s.sizeId = p.proSize WHERE bp.bpBid ='". $row['billUid'] ."'";

$proRecs = mysqli_query($conn, $proRec);
// print_r($proRecs);

?>

<?php include 'header.php'; ?>

<!-- Modal -->
<div class="modal fade editRecPro" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Received Product</h4>
					<p class="card-description">
						Fill Received Product Details
					</p>
					<div class="form-group row">
						<label for="exampleInputUsername2" class="col-sm-4 col-form-label">Qty Received :</label>
						<div class="col-sm-8">
							<input type="number" class="form-control" min="1" name="recQty" id="recQty" placeholder="Enter Quantity">
						</div>
						<label for="exampleInputUsername2" class="col-sm-4 col-form-label">Received Date :</label>
						<div class="col-sm-8">
							<input type="date" class="form-control form-control-sm" name="recDate" id="recDate">
						</div>
					</div>
					<div id="progressBar"></div>
					<br>
					<input type="hidden" id="BPRQty" value="0">
					<input type="hidden" id="BPQty" value="0">
					<input type="hidden" id="BPId" value="0">
					<center>
						<button class="btn btn-gradient-success mr-2" onclick="confirmEdit();">Confirm</button>
						<button class="btn btn-light btn-gradient-danger" data-dismiss="modal">Cancel</button>
					</center>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modals end -->
<div class="modal fade viewRecs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title text-danger">Received Product Records</h4>
					<span id="outRec"></span>
					<br>
					<button class="btn btn-light btn-gradient-primary btn-sm btn-block" data-dismiss="modal">
						<i class="mdi mdi-window-close"></i>&nbsp;Close
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
		

<div class="main-panel">
	<div class="content-wrapper">
		<div class="page-header">
			<h3 class="page-title">
				<span class="page-title-icon bg-gradient-primary text-white mr-2">
					<i class="mdi mdi-worker"></i>                 
				</span>
				INVOICE DETAILS
			</h3>
		</div>
		<span id="updatedInvoice">
			<div class="card">
				<div class="card-body">				
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
								<thead class="text-center">
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
											Received Qty.
										</th>
										<th>
											Edit
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
											<td><?php echo $pro['bpRQty'] ?></td>
											<td><center>
												<button type="button" class="btn btn-gradient-primary btn-sm" id="<?php echo $pro['bpId']; ?>" onclick="setId(this.id,<?php echo $pro['bpQty'] ?>,<?php echo $pro['bpRQty'] ?>);" data-toggle="modal" data-target=".editRecPro">
													<i class="mdi mdi-table-edit"></i>
												</button>
												<button type="button" class="btn btn-gradient-success btn-sm" id="<?php echo $pro['bpId'];?>" onclick="viewRecs(this.id);" data-toggle="modal" data-target=".viewRecs">
													<i class="mdi mdi-eye"></i>
												</button>
											</center></td>
											<td><?php echo $pro['bpPrice'] * $pro['bpQty']." &#8377;" ?></td>

										</tr>							
									<?php } ?>
									<tr>
										<td colspan="6"></td>
										<td><h4 class="text-right">Total : <?php echo $row['billAmount']." &#8377;" ?></h4></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</span>
	</div>
</div>

<script type="text/javascript">
	function setId(bpId,qty,rqty){
		$('#BPId').val(bpId);
		$('#BPQty').val(qty);
		$('#BPRQty').val(rqty);
	}
</script>
<script type="text/javascript">
	function confirmEdit(){
		var qty = parseInt($('#BPQty').val());
		var rqty = parseInt($('#BPRQty').val());
		var uqty = parseInt($('#recQty').val());
		var cal = qty-rqty;
		// alert(cal); 
		if (uqty <= cal) {
			$("#progressBar").html('<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"><br>');
			$.ajax({
				type: "POST",
				url: './api/addRecPro.php',
				data: {bpId:$('#BPId').val(),recQty:$('#recQty').val(),recDate:$('#recDate').val()},
				success:function(msg) {
					$('#progressBar').html(msg);
				// $("#progressBar").html('');
				}
			});
		}else{
			$('#progressBar').html("Only "+cal+" products can be received...");
		}		
	}
</script>
<script type="text/javascript">
	function viewRecs(id){		
		$("#outRec").html('<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">');
		$.ajax({
			type: "POST",
			url: './api/viewRec.php',
			data: {bpId:id},
			success:function(msg) {
				$('#outRec').html(msg);
			}
		});
	}
</script>
<?php include 'footer.php'; ?>