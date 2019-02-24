<?php

require "../../config.php";

$conn = connection();

$condition = "";

if(isset($_POST['name']) && $_POST['name']!=""){
	$condition .=" AND catName like '".$_POST['name']."%'";
}

$check = "SELECT *  FROM `category` WHERE 1 $condition ORDER BY `catName`";

$rs = mysqli_query($conn, $check);

?>
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
                     foreach ($rs as $row){ $s++; ?>
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
<?php  ?>