<?php

require "../config.php";
$conn = connection();
$workerDetails = mysqli_query($conn, "SELECT * FROM `worker` ORDER BY `name`");
$ledgerDetails = mysqli_query($conn, "SELECT * FROM ledger l INNER JOIN worker w on l.ledgerWorkerId = w.Id ORDER BY `name`");

?>

<?php include('header.php'); ?>

<!-- Add record modal start -->

<div class="modal fade add-record-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add record</h4>
            <p class="card-description">
              Fill record details
            </p>
              <div class="form-group row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Name :</label>
                <div class="col-sm-8">
                  <select class="form-control" id="name">
                        <option value="">Select Name</option>
                        <?php foreach ($workerDetails as $row) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo ucwords($row['name']); ?></option>
                <?php } ?>
                      </select>
                </div>
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Amount :</label>
                <div class="col-sm-8">
                  <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter Amount">
                </div>
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Note :</label>
                <div class="col-sm-8">
                  <textarea class="form-control form-control-sm" name="note" id="note"></textarea>
                </div>
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Date :</label>
                <div class="col-sm-8">
                <input type="date" class="form-control form-control-md" name="date" id="date" placeholder="Select date">
              </div>
              </div>
              <div id="progress"></div>
            <p id="output" class="card-description text-success"></p>
                <center>
                <button class="btn btn-gradient-success mr-2" onclick="addRecord();">Submit</button>
                <button class="btn btn-light btn-gradient-danger" data-dismiss="modal">Cancel</button>
              </center>
            </div>
          </div>
      </div>
    </div>
  </div>

<!-- Add record modal end -->

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
          <i class=" mdi mdi-book-open-page-variant"></i>                 
        </span>
        Ledger
      </h3>
    </div>
    <div class="card">
     <div class="card-body">
      <div class="card-description">
       <div class="form-group">
         <div class="row">
          <div class="col-sm-4">
            <label for="name">Search Name :</label>
            <input type="text" class="form-control form-control-md" placeholder="Worker's name" id="srchName">
          </div>
          <div class="col-sm-4">
            <label for="name">Date :</label>
            <input type="date" class="form-control form-control-md" name="srchDate" id="srchDate" placeholder="Select date" aria-label="Username">
          </div>
          <div class="col-sm-2">
            <label for="name">&nbsp;</label>
          <button class="btn btn-md btn-gradient-danger" onclick="srchLedger();">Search</button>
        </div>
         <div class="col-sm-2">
          <label for="name">&nbsp;</label>
          <button class="btn btn-md btn-gradient-success" type="button" data-toggle="modal" data-target=".add-record-modal">Add record</button>
          </div>
       </div>
     </div>
   </div>
   <div id="srchOutput">
     <table class="table table-bordered">
      <thead>
       <tr>
        <th>
         #
       </th>
       <th>
         Name
       </th>
       <th>
         Amount
       </th>
       <th>
         Note
       </th>
       <th>
         Date
       </th>
     </tr>
   </thead>
   <tbody>

     <?php $s=0; foreach ($ledgerDetails as $row){ $s++; ?>
      <tr>
       <td>
        <?php echo $s."."; ?>
      </td>
      <td>
        <?php echo ucwords($row['name']); ?>
      </td>
      <td>
        <?php echo $row['ledgerAmt']; ?>
      </td>
      <td>
       <?php echo $row['ledgerNote'];?>
   </td>
   <td>
       <?php echo date('d/m/Y',strtotime($row['ledgerEntryDt']));?>
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

<script>
  function addRecord()
  {
  	  $('#output').html('');
  		$("#progress").html('<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">');
  		$.ajax({
  			type: "POST",
  			url: './api/addRecord.php',
  			data: {name:$('#name').val(),amount:$('#amount').val(),note:$('#note').val(),date:$('#date').val()},
  			success:function(msg) {
  				$('#output').html(msg);
  				$("#progress").html('');
  			}
  		});  
  }
</script>
<script type="text/javascript">
	function srchLedger()
  {
      $.ajax({
        type: "POST",
        url: './api/srchLedger.php',
        data: {name:$('#srchName').val(),date:$('#srchDate').val()},
        success:function(msg) {
          $('#srchOutput').html(msg);
        }
      });  
  }
</script>


<?php include('footer.php'); ?>