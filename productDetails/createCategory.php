<?php

require "../config.php";
$conn = connection();

$catDetails = mysqli_query($conn, "SELECT * FROM `category` ORDER BY `catName` ASC");

?>

<?php include('header.php'); ?>

<!-- Category modal start -->
<div class="modal fade category-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Create Category</h4>
            <p class="card-description">
              Fill category details
            </p>
            
              <div class="form-group row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Enter Category</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="category" id="category" placeholder="Enter category">
                </div>
              </div>
              <div id="progress1"></div>
            <p id="output1" class="card-description text-success"></p>
                <center>
                <button class="btn btn-gradient-success mr-2" onclick="addCategory();">Submit</button>
                <button class="btn btn-light btn-gradient-danger" data-dismiss="modal">Cancel</button>
              </center>
              
            </div>
          </div>
      </div>
    </div>
  </div>

<!-- Category modal end -->
  
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title col-md-9">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-shopping"></i>                 
              </span>
              Category Details
            </h3>
            <button type="button" class="btn btn-sm btn-gradient-primary" style="float: right;"   type="button" data-toggle="modal" data-target=".category-modal">Create Category</button>
          </div>          
          <div class=" grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-description">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Category name" aria-label="Product's name" aria-describedby="basic-addon2" id="srchCategory">
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-gradient-danger" type="button"  onclick="srchCategory();">Search</button>
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
                        Name
                      </th>                    
                    </tr>
                  </thead>
                  <tbody>
                   <?php $s=0;
                     foreach ($catDetails as $row){ $s++; ?>
                    <tr>
                      <td>
                        <?php echo $s;?>
                      </td>
                      <td>
                        <?php echo $row['catName']; } ?>
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
  function addCategory()
  {
    if ($.trim($('#category').val()) != "") {
    $('#output1').html('');
    $("#progress1").html('<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">');  
    $.ajax({
        type: "POST",
        url: './api/addCategory.php',
        data: {category:$('#category').val()},
        success:function(msg) {
          $('#output1').html(msg);
          $("#progress1").html('');
        }
      });
    }
    else{
      $('#output').html("<span class='text-danger'>Please fill all the details...</span>");
    } 

  }
</script>

<script>
  function srchCategory(){
    $.ajax({
        type: "POST",
        url: './api/srchCategory.php',
        data: {name:$('#srchCategory').val()},
        success:function(msg) {
          $('#srchOutput').html(msg);
        }
      });
  }
</script>


<?php include('footer.php'); ?>