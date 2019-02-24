<?php

require "../config.php";
$conn = connection();
$workerDetails = mysqli_query($conn, "SELECT * FROM `worker` ORDER BY `name`");

?>

<?php include('header.php'); ?>

<div class="modal fade addWorker" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Add new worker</h4>
          <p class="card-description">
            Fill worker details
          </p>
          <!-- <form class="forms-sample"> -->
            <div class="form-group row">
              <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
              </div>
            </div>
            <div class="form-group row">
              <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Mobile</label>
              <div class="col-sm-9">
                <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile number">
              </div>
            </div>
 			      <div id="progress"></div>
            <p id="output" class="card-description text-success"></p>
            <button class="btn btn-gradient-success mr-2" onclick="addWorker();">Submit</button>
            <button class="btn btn-light btn-gradient-danger" data-dismiss="modal">Cancel</button>            
          <!-- </form> -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Model -->
<!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-worker"></i>                 
              </span>
              Worker Details
            </h3>
          </div>
          <div class="card">
          	<div class="card-body">
          		<div class="card-description">
          			<div class="form-group">
          				<!-- <form> -->
          					<div class="input-group">
          						<input type="text" class="form-control" placeholder="Worker's name" id="srchName">
          						<div class="input-group-append">
          							<button class="btn btn-sm btn-gradient-danger" onclick="srchWorker();">Search</button>
          						</div>
          						<div class="input-group-append">
          							<button class="btn btn-sm btn-gradient-success" type="button" data-toggle="modal" data-target=".addWorker">Add Worker</button>
          						</div>
          					</div>
          				<!-- </form> -->
          			</div>
          		</div>
          		<div id="srchOutput">
          			<table class="table table-bordered">
          				<thead>
          					<tr>
          						<th>
          							User
          						</th>
          						<th>
          							Name
          						</th>
          						<th>
          							Mobile
          						</th>
          						<th>
          							Action
          						</th>
          					</tr>
          				</thead>
          				<tbody>

          					<?php $s=0; foreach ($workerDetails as $row){ $s++; ?>
          						<tr>
          							<td>
          								<?php echo $s."."; ?>
          							</td>
          							<td>
          								<?php echo ucwords($row['name']); ?>
          							</td>
          							<td>
          								<?php echo $row['mobile']; ?>
          							</td>
          							<td>
          								<center>
          									<form method="POST" action="workerProfile.php">
          										<input type="text" name="workerID" value="<?php echo $row['id']; ?>" hidden>
          										<button type="submit" class="btn btn-gradient-info btn-sm">
          											<i class="mdi mdi-eye">&nbsp;View</i>
          										</button>
          									</form>
          								</center>
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
  function addWorker()
  {
  	if ($.trim($('#name').val()) != "" && $.trim($('#mobile').val()) != "") {
  		$('#output').html('');
  		$("#progress").html('<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">');
  		$.ajax({
  			type: "POST",
  			url: './api/addWorker.php',
  			data: {name:$('#name').val(),mobile:$('#mobile').val()},
  			success:function(msg) {
  				$('#output').html(msg);
  				$("#progress").html('');
  			}
  		});
  	}
  	else{
  		$('#output').html("<span class='text-danger'>Please fill all the details...</span>");
  	}   
  }
</script>
<script type="text/javascript">
	function srchWorker(){
		$.ajax({
  			type: "POST",
  			url: './api/srchWorker.php',
  			data: {name:$('#srchName').val()},
  			success:function(msg) {
  				$('#srchOutput').html(msg);
  			}
  		});
	}
</script>


<?php include('footer.php'); ?>