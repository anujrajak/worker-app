<?php

$id = $_POST['workerID'];
require "../config.php";
$conn = connection();
$check = "SELECT *  FROM `worker` WHERE `id` = '$id'";
$rs = mysqli_query($conn, $check);
foreach ($rs as $row ) {}

$billRecs = mysqli_query($conn, "SELECT * FROM `billrecords` br INNER JOIN worker w ON w.id = br.workerId WHERE br.workerId = $id ORDER BY billDate DESC");
$productList = mysqli_query($conn, "SELECT * FROM `workerproduct` wp INNER JOIN product p ON p.proId=wp.wpProductId INNER JOIN category c ON p.proCat = c.catId INNER JOIN size s ON s.sizeId = p.proSize WHERE wpWorkerId =".$id );
$proDetails = mysqli_query($conn, "SELECT * FROM product p inner join category c on c.catId=p.proCat inner join size s on s.sizeId=p.proSize  ORDER BY c.catName ASC");
?>

<?php include("header.php"); ?>

<!-- Modal -->
<div class="modal fade confirmOrder" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="card">
        <div class="card-body text-center">
          <blockquote class="blockquote blockquote-primary">
            <h4>Have you received this order if yes then please click in confirm button.</h4>
            <span id="progress"></span>
          </blockquote>
          <input type="hidden" id="BillId" value="">          
          <button class="btn btn-gradient-success mr-2" onclick="confirmOrder();" data-dismiss="modal">Confirm</button>
            <button class="btn btn-light btn-gradient-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modals end -->
<!-- Modal -->
<div class="modal fade assignProduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Assign Product</h4>
					<div class="form-inline">
						<label class="sr-only" for="inlineFormInputName2">Product</label>
						<select class="form-control mb-2 mr-sm-2" id="productId" style="height: 43px;width: 33.33%;">
							<option value="">Select Product</option>
							<?php foreach ($proDetails as $pro) { ?>
								<option value="<?php echo $pro['proId']; ?>"><?php echo ucwords($pro['catName'])." : ".ucwords($pro['sizeName']); ?></option>
							<?php } ?>
						</select>						

						<label class="sr-only" for="inlineFormInputGroupUsername2">Price</label>
						<input type="number" class="form-control mb-2 mr-sm-2" id="proPrice" placeholder="Enter price..." style="width: 33.33%;">
						
						<button type="submit" class="btn btn-gradient-primary mb-2" onclick="assignProduct()">Create Product</button>
						&nbsp;
						<button class="btn btn-gradient-danger btn-icon" data-dismiss="modal" style="margin-top: -9px;">
							<i class="mdi mdi-close"></i>
						</button>
					</div>
					<span id="assignWorkerProduct">
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
					</span>
					<input type="hidden" id="workerID" value="<?php echo $_POST['workerID']; ?>">          
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modals end -->
<!-- Modal -->
<div class="modal fade viewBill" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="card">
        <div class="card-body">          
          <span id="viewInvoice">
          	
          </span>    
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modals end -->

<div class="content-wrapper">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body bg-gradient-danger">
					<div class="row ">
						<div class="col-lg-12">
							<div class="d-flex justify-content-between">
								<div>
									<small class="text-white">Name:</small>
									<h3 class="text-white"><?php echo ucwords($row['name']) ?></h3>
								</div>
								<div>
									<small class="text-white">Mobile:</small>
									<h3 class="text-white"><?php echo $row['mobile'] ?></h3>
								</div>
								<div>
									<small>&nbsp;<br></small>
									<button class="btn btn-gradient-info btn-sm" data-toggle="modal" data-target=".assignProduct">
										<i class="mdi mdi-list-check">&nbsp;Products List</i>
									</button>
									<button class="btn btn-gradient-warning btn-sm">
										<i class="mdi mdi-eye">&nbsp;View</i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table class="table table-hover table-bordered">
						<thead class="bg-gradient-primary text-white">
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Amount</th>
								<th>Order Date</th>
								<th>Delivery Date</th>
								<th>Status</th>
								<th>Action</th>                        
							</tr>
						</thead>
						<tbody>
							<?php $s=0; foreach ($billRecs as $row) { $s++; ?>
								<tr>
									<td><?php echo $s."." ?></td>
									<td><?php echo ucwords($row['name']); ?></td>
									<td><?php echo $row['billAmount']." /-" ?></td>
									<td><?php echo $row['billDate']; ?></td>
									<td><?php echo $row['billRecDate']; ?></td>
									<td>
										<?php if ($row['billStatus'] == '1') { ?>
											<label class="badge badge-danger">Pending</label>
										<?php } else { ?>
											<label class="badge badge-success">Received</label>
										<?php } ?>
									</td>
									<td>
										<button type="button" class="btn btn-gradient-info btn-sm" id="<?php echo $row['billId'];?>" onclick="viewBill(this.id);" data-toggle="modal" data-target=".viewBill">
											<i class="mdi mdi-eye"></i>
										</button>
										<?php if ($row['billStatus'] == '2') { ?>
											<button type="button" class="btn btn-success btn-sm" disabled>
												<i class="mdi mdi-check">&nbsp; Confirmed</i>
											</button>
										<?php } else { ?>
											<button type="button" class="btn btn-gradient-warning btn-sm" data-toggle="modal" data-target=".confirmOrder" id="<?php echo $row['billId'] ?>" onclick="setID(this.id);">
												<i class="mdi mdi-cancel">&nbsp; Confirm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
											</button>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
                </div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
  function setID(id){
    $('#BillId').val(id);
  }
</script>
<script>
  function confirmOrder(id)
  {
      $("#progress").html('<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">');
      $.ajax({
        type: "POST",
        url: './api/confirmOrder.php',
        data: {id:$('#BillId').val()},
        success:function(msg) {
          $("#progress").html(msg);
        }
      });
  }
</script>
<script type="text/javascript">
	function viewBill(id){
	  $("#viewInvoice").html('<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">');
      $.ajax({
        type: "POST",
        url: './api/viewBill.php',
        data: {id:id},
        success:function(msg) {
          $("#viewInvoice").html(msg);
        }
      });
	}
</script>
<script type="text/javascript">
	function assignProduct(){
		if ($('#productId').val() != "" && $('#proPrice').val() != "") {
			$("#assignWorkerProduct").html('<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">');
			$.ajax({
				type: "POST",
				url: './api/assignProduct.php',
				data: {workerId:$('#workerID').val(),productId:$('#productId').val(),proPrice:$('#proPrice').val()},
				success:function(msg) {
					$('#assignWorkerProduct').html(msg);
				}
			});
		}else{
			alert("Please fill all the details...");
		}
		
	}
</script>

<?php include("footer.php"); ?>