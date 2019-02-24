<?php

require "../config.php";
$conn = connection();

$catDetails = mysqli_query($conn, "SELECT * FROM `category` ORDER BY `catName` ASC");
$sizeDetails = mysqli_query($conn, "SELECT * FROM `size` ORDER BY `sizeName` ASC");
$proDetails = mysqli_query($conn, "SELECT * FROM product p inner join category c on c.catId=p.proCat inner join size s on s.sizeId=p.proSize  ORDER BY c.catName ASC");
?>

<?php include('header.php'); ?>


<!-- Create product modal start -->
   
<div class="modal fade create-product-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add new product</h4>
            <p class="card-description">
              Fill product details
            </p>
           
              <div class="form-group row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Select Category</label>
                <div class="col-sm-8">
                    <select class="form-control" id="proCategory">

                        <option value="">Select Category</option>
                        <?php foreach ($catDetails as $row) { ?>
                <option value="<?php echo $row['catId']; ?>"><?php echo ucwords($row['catName']); ?></option>
                <?php } ?>
                      </select>
                </div>
              </div>
              <div class="form-group row">
                  <label for="exampleInputEmail2" class="col-sm-4 col-form-label">Select Size</label>
                  <div class="col-sm-8">
                    <select class="form-control" id="proSize">
                        <option value="">Select Size</option>
                        <?php foreach ($sizeDetails as $row) { ?>
                <option value="<?php echo $row['sizeId']; ?>"><?php echo ucwords($row['sizeName']); ?></option>
                <?php } ?>
                      </select>
                  </div>
                </div>
              <!-- <div class="form-group row">
                  <label for="exampleInputEmail2" class="col-sm-4 col-form-label">Price</label>
                  <div class="col-sm-8">
                    <input type="email" class="form-control" id="proPrice" placeholder="Enter Price">
                  </div>
                </div> -->
                <div id="progress2"></div>
            <p id="output2" class="card-description text-success"></p>
                <center>
                <button class="btn btn-gradient-success mr-2" onclick="createProduct();">Submit</button>
                <button class="btn btn-light btn-gradient-danger" data-dismiss="modal">Cancel</button>
              </center>
              
            </div>
          </div>
      </div>
    </div>
  </div>
    
<!-- Create product modal end -->

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
              Product Details
            </h3>
            <button type="button" class="btn btn-sm btn-gradient-primary" style="float: right;"   type="button" data-toggle="modal" data-target=".category-modal">Create Category</button>  
           <button type="button" class="btn btn-sm btn-gradient-primary"  type="button" data-toggle="modal" data-target=".size-modal">Add Size</button>
          </div>          
          <div class=" grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-description">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Product's name" aria-label="Product's name" aria-describedby="basic-addon2" id="srchProduct">
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-gradient-danger" type="button"  onclick="srchProduct();">Search</button>
                      </div>
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-gradient-success" type="button" data-toggle="modal" data-target=".create-product-modal">Create Product</button>
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
                      <th>
                        Size
                      </th>                      
                    </tr>
                  </thead>
                  <tbody>
                   <?php $s=0;
                     foreach ($proDetails as $row){ $s++; ?>
                    <tr>
                      <td>
                        <?php echo $s;?>
                      </td>
                      <td>
                        <?php echo $row['catName']; ?>
                      </td>
                      <td>
                        <?php echo $row['sizeName']; ?>
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
  function createProduct(){
     if ($.trim($('#proCategory').val()) != "" && $.trim($('#proSize').val()) != "") {
    $('#output2').html('');
    $("#progress2").html('<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">');  
    $.ajax({
        type: "POST",
        url: './api/createProduct.php',
        data: {proCategory:$('#proCategory').val(),proSize:$('#proSize').val()},
        success:function(msg) {
          $('#output2').html(msg);
          $("#progress2").html('');
        }
      });
    }
    else{
      $('#output').html("<span class='text-danger'>Please fill all the details...</span>");
    }
  }
</script>
<script type="text/javascript">
  function srchProduct(){
    $.ajax({
        type: "POST",
        url: './api/srchProduct.php',
        data: {name:$('#srchProduct').val()},
        success:function(msg) {
          $('#srchOutput').html(msg);
        }
      });
  }
</script>


<?php include('footer.php'); ?>