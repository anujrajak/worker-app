<?php

require "../../config.php";

$conn = connection();

$condition = "";

if(isset($_POST['name']) && $_POST['name']!=""){
	$condition .=" AND name like '".$_POST['name']."%'";
}

$check = "SELECT *  FROM `worker` WHERE 1 $condition ORDER BY `name`";

$rs = mysqli_query($conn, $check);

$s=0; foreach ($rs as $row){ $s++; ?>
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
			
			<?php $s=0; foreach ($rs as $row){ $s++; ?>
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
							<button type="button" class="btn btn-gradient-warning btn-sm">
								<i class="mdi mdi-eye">&nbsp;View</i>
							</button>
						</center>
					</td>
				</tr> 
			<?php } ?>			
		</tbody>
	</table>
<?php } ?>