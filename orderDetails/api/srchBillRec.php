<?php

require "../../config.php";

$conn = connection();

$condition = "";

if(isset($_POST['id']) && $_POST['id']!=""){
	$condition .=" AND workerId = '".$_POST['id']."'";
}

$check = "SELECT * FROM `billrecords` br INNER JOIN worker w ON w.id = br.workerId WHERE 1=1 $condition ORDER BY billDate DESC";

$rs = mysqli_query($conn, $check);

?>
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
		<?php $s=0; foreach ($rs as $row) { $s++; ?>
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
				<td>
					<button type="button" class="btn btn-gradient-info btn-sm" id="<?php echo $row['billId'];?>" onclick="viewBill(this.id);" data-toggle="modal" data-target=".viewBill">
						<i class="mdi mdi-eye"></i>
					</button>
					<?php if ($row['billStatus'] == '2') { ?>
						<button type="button" class="btn btn-success btn-sm" disabled>
							<i class="mdi mdi-check">&nbsp; Confirmed</i>
						</button>
					<?php } else { ?>
						<button type="button" class="btn btn-gradient-warning btn-sm" data-toggle="modal" data-target=".confirmOrder" id="<?php echo $row['billId'] ?>" onclick="setID(this.id);">
							<i class="mdi mdi-cancel">&nbsp; Confirm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
						</button>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>