<?php

require "../config.php";
$conn = connection();
$billRecs = mysqli_query($conn, "SELECT * FROM `billrecords` br INNER JOIN worker w ON w.id = br.workerId ORDER BY billDate DESC");
$workerDetails = mysqli_query($conn, "SELECT * FROM worker ORDER BY name");

?>

<?php include('header.php'); ?>

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

<!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-worker"></i>                 
              </span>
              Order Details
            </h3>
          </div>
          <div class="card">
          	<div class="card-body">
          		<div class="card-description">
          			<div class="form-group">          				
          					<div class="input-group">
                      <select class="form-control" name="srchWid" id="srchWid">
                        <option value="" >Select worker</option>
                        <?php foreach ($workerDetails as $row) { ?>
                          <option value="<?php echo $row['id']; ?>"><?php echo ucwords($row['name'])."-".$row['mobile']; ?></option>
                        <?php } ?>                
                      </select>
          						<div class="input-group-append">
          							<button class="btn btn-sm btn-gradient-danger" onclick="srchWorker();">Search</button>
                        <form method="POST" action="makeOrder.php">
          						</div>
          						<div class="input-group-append">                        
                          <button class="btn btn-sm btn-gradient-success" type="submit">Add New Order</button>          							
          						</div>
          					</div>
          				</form>
          			</div>
          		</div>
          		<div id="srchOutput">
          			<table class="table table-bordered">
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
                        <td style="display: flex;">
                          <button type="button" class="btn btn-gradient-info btn-sm" id="<?php echo $row['billId'];?>" onclick="viewBill(this.id);" data-toggle="modal" data-target=".viewBill">
                            <i class="mdi mdi-eye"></i>
                          </button>
                          &nbsp;
                          <form method="POST" action="orderRec.php">
                            <input type="hidden" name="billId" value="<?php echo $row['billId'];?>">
                            <button type="submit" class="btn btn-gradient-warning btn-sm">
                              <i class="mdi mdi-table-edit"></i>
                            </button>
                          </form>
                          &nbsp;
                          <!-- <?php if ($row['billStatus'] == '2') { ?>
                            <button type="button" class="btn btn-success btn-sm" disabled>
                              <i class="mdi mdi-check" >&nbsp; Confirmed</i>
                            </button>
                          <?php } else { ?>
                            <button type="button" class="btn btn-gradient-warning btn-sm" data-toggle="modal" data-target=".confirmOrder" id="<?php echo $row['billId'] ?>" onclick="setID(this.id);">
                              <i class="mdi mdi-cancel">&nbsp; Confirm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                            </button>
                          <?php } ?> -->
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
  function srchWorker(){
    $.ajax({
        type: "POST",
        url: './api/srchBillRec.php',
        data: {id:$('#srchWid').val()},
        success:function(msg) {
          $('#srchOutput').html(msg);
        }
      });
  }
</script>

<?php include('footer.php'); ?>