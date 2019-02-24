<?php

require "../../config.php";

$conn = connection();

$condition = "";

if(isset($_POST['name']) && $_POST['name']!=""){
	$condition .=" AND name like '".$_POST['name']."%'";
}

$check = "SELECT * FROM product p inner join category c on c.catId=p.proCat inner join size s on s.sizeId=p.proSize  ORDER BY c.catName ASC";

$rs = mysqli_query($conn, $check); ?>

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
                   <?php $s=0; foreach ($rs as $row){ $s++; ?>
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
