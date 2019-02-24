<?php

require "../config.php";
$conn = connection();

$sizeDetails = mysqli_query($conn, "SELECT * FROM `size` ORDER BY `sizeName` ASC");

?>

<?php include('header.php'); ?>


<!-- Size modal start -->
<div class="modal fade size-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add Size</h4>
            <p class="card-description">
              Fill size details
            </p>
            <!-- <form class="forms-sample" method="POST">  -->
              <div class="form-group row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Enter Size</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="size" id="size" placeholder="Enter Size">
                </div>
              </div>
              <div id="progress"></div>
            <p id="output" class="card-description text-success"></p>
                <center>
                <button class="btn btn-gradient-success mr-2" onclick="addSize();">Submit</button>
                <button class="btn btn-light btn-gradient-danger" data-dismiss="modal">Cancel</button>
              </center>
              <!-- </form> -->
            </div>
          </div>
      </div>
    </div>
  </div>

<!-- Size modal end -->

  
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title col-md-9">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-shopping"></i>                 
              </span>
              Size Details
            </h3>
            <!-- <button type="button" class="btn btn-sm btn-gradient-primary" style="float: right;"   type="button" data-toggle="modal" data-target=".category-modal">Create Category</button>   -->
           <button type="button" class="btn btn-sm btn-gradient-primary"  type="button" data-toggle="modal" data-target=".size-modal">Add Size</button>
          </div>          
          <div class=" grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-description">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Enter Size" aria-label="Enter Size" aria-describedby="basic-addon2" id="srchSize">
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-gradient-danger" type="button"  onclick="srchSize();">Search</button>
                      </div>
                    </div>
                  </div>
                </p>               
                <div id="srchOutput">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        #
                      </th>
                      <th>
                        Size
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php $s=0;
                     foreach ($sizeDetails as $row){ $s++; ?>
                    <tr>
                      <td>
                        <?php echo $s;?>
                      </td>
                      <td>
                        <?php echo $row['sizeName']; } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
               </div>
              </div>
            </div>
          </div>
         
        </div>

      </div>

<script>
  function addSize()
  {
    if ($.trim($('#size').val()) != "") {
    $('#output').html('');
    $("#progress").html('<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">');  
    $.ajax({
        type: "POST",
        url: './api/addSize.php',
        data: {size:$('#size').val()},
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
  function srchSize(){
    $.ajax({
        type: "POST",
        url: './api/srchSize.php',
        data: {name:$('#srchSize').val()},
        success:function(msg) {
          $('#srchOutput').html(msg);
        }
      });
  }
</script>

<?php include('footer.php'); ?>