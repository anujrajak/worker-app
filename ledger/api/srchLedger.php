<?php

require "../../config.php";

$conn = connection();

$condition = "";

$name = $_POST['name'];
$date = $_POST['date'];

// echo $name,$date;
// die();

if(isset($_POST['name']) && $_POST['name']!=""){
	$condition .=" AND name like '".$_POST['name']."%'";
}

if (isset($_POST['date']) && $_POST['date']!="") {
	$condition .=" AND ledgerEntryDt like '".$_POST['date']."%'";
}

$check = "SELECT * FROM ledger l INNER JOIN worker w on l.ledgerWorkerId = w.Id  WHERE 1 $condition ORDER BY `name`";

$rs = mysqli_query($conn, $check);

$s=0; foreach ($rs as $row){ $s++; ?>
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

     <?php $s=0; foreach ($rs as $row){ $s++; ?>
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
<?php } ?>