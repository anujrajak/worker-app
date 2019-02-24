<?php
require "../config.php";
$conn = connection();
$workerDetails = mysqli_query($conn, "SELECT * FROM worker ORDER BY name");
$categoryDetails = mysqli_query($conn, "SELECT * FROM category ORDER BY catName");

?>

<?php include("header.php"); ?>
<form method="POST" onsubmit="grandCalc();" action="addOrder.php">
<div class="main-panel" style="width: 100% !important;">
	<div class="content-wrapper">
		<div class="card">
			<div class="card-body">
				<div class="card-description ">
					
					<div class="row">
						<div class="col-sm-4">
							<label for="name">Worker Name :</label>
							<select class="form-control" name="workerId" id="workerId" onchange="getWorkerProducts(this.value)">
								<option value="">Select worker</option>
								<?php foreach ($workerDetails as $row) { ?>
									<option value="<?php echo $row['id']; ?>"><?php echo ucwords($row['name'])."-".$row['mobile']; ?></option>
								<?php } ?>								
							</select>
						</div>
						<div class="col-sm-4">
							<label for="name">Delivery Date :</label>
							<input type="date" class="form-control form-control-sm" name="delivery" placeholder="Select date" aria-label="Username">
						</div>
						<div class="col-sm-4">
							<label for="name">&nbsp;</label>
							<button type="submit" class="btn btn-gradient-primary btn-block">Submit</button>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-6" id="workerProductList">
							<label for="name">Product :</label>
							<select class="form-control " id="productId" onchange="getPrice()">
								<option>Select Product</option>
								<?php foreach ($productDetails as $row) { ?>
									<option value="<?php echo $row['wpProductId']; ?>"><?php echo ucwords($row['catName']." : ".$row['sizeName']); ?></option>
								<?php } ?>								
							</select>
						</div>
						<!-- <div class="col-sm-3">
							<label for="name">Size :</label>
							<span id="sizeDropdown">
								<select class="form-control " id="sizeId">
									<option>Select size</option>							
								</select>
							</span>
						</div> -->
						<div class="col-sm-2">
							<label for="name">Price :</label>
							<span id="priceRS">
								<input type="number" class="form-control" name="" id="" placeholder="Enter price" disabled>
							</span>
						</div>
						<div class="col-sm-2">
							<label for="name">Quantity :</label>
							<input type="number" class="form-control" min="1" name="qty" id="qty" placeholder="Enter qty.">
						</div>
						<div class="col-sm-2">
							<label for="name">&nbsp;</label>
							<button type="button" class="btn btn-gradient-success btn-block" onclick="addRow();">
		                      Add Row
		                    </button>
						</div>
					</div>
				</div>
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
						<tr id="fetch_d_0">

						</tr>
					</tbody>
				</table>

				<input type="hidden" name="count" id="count" value="0">
				<input type="hidden" name="total_amt" id="total_amt" value="0" required="">
				
			</div>
		</div>
	</div>
</div>
</form>

<script type="text/javascript">
	function getSize(id){
		$.ajax({
  			type: "POST",
  			url: './api/getSize.php',
  			data: {id:id},
  			success:function(msg) {
  				$('#sizeDropdown').html(msg);
  			}
  		});
	}
</script>
<script type="text/javascript">
	function getPrice(){
		$.ajax({
  			type: "POST",
  			url: './api/getPrice.php',
  			data: {workerId:$('#workerId').val(),productId:$('#productId').val()},
  			success:function(msg) {
  				// alert(msg);
  				$('#priceRS').html(msg);
  			}
  		});
	}
</script>
<script type="text/javascript">
	function calc(qty,id){
		var count = id.split("_");
		count = count[count.length - 1];
		var price = parseInt($('#proPrice_'+count).val());
		var qt = parseInt(qty);
		$('#total_'+count).val(price*qt);
	}
</script>
<script type="text/javascript">
	function grandCalc(){
		var c = $('#count').val();
		var count = parseInt(c);
	    var total = 0;
	    var temp = 0;
	    for(var i = 0; i < count; i++) {
	    	temp = parseInt($('#total_'+i).val());
	      	total = total+temp;
	    }
	    // alert(total);
	    $('#total_amt').val(total);
	}
</script>
<script type="text/javascript">
	function addRow() {
		if ($('#qty').val() != "") {
			var count = parseInt($('#count').val());
			var productId = $('#productId').val();
			var qty = $('#qty').val();
			var last = count-1;
			var nxt = count;
			// alert($('#productId').val())
			$( "#fetch_d_"+last).after( '<tr id="fetch_d_'+nxt+'"></tr>' );

			console.log(count,productId,qty,last,nxt,count);

			$.ajax({
				type: "POST",
				url: './api/add_row.php',
				data: {count:count,productId:$('#productId').val(),workerId:$('#workerId').val(),qty:qty},
				success:function(msg) {
		        // console.log(msg);
		        // alert(msg);
		        $('#fetch_d_'+count).html(msg);
		        $('input[name="count"]').val(count+1);
		        // $('#sty_grp').attr("disabled","disabled");        
		    }
		});
		}else{
			alert("Please enter quantity...");
		}		
	}
</script>
<script type="text/javascript">
	function getWorkerProducts(workerId){
		$.ajax({
  			type: "POST",
  			url: './api/getWorkerProducts.php',
  			data: {workerId:workerId},
  			success:function(msg) {
  				// alert(msg);
  				$('#workerProductList').html(msg);
  			}
  		});
	}
</script>

<?php include("footer.php"); ?>