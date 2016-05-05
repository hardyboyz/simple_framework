<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{	
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<div class="box" style="width:85%">
<?php
$setTable	= "booking";
if(isset($_GET['approved'])){
	$params['status_booking'] = 1;
	update($setTable,"id_booking",$_GET['id'],$params);
	echo "<script>window.location='".$_GET['url']."';</script>";
	exit;
}

if(isset($_GET['rejected'])){
	$params['status'] = 0;
	update($setTable,"id_booking",$_GET['id'],$params);
	echo "<script>window.location='".$_GET['url']."';</script>";
	exit;
}
?>

<label><?php echo $content['title'] ?></label>

<div class="form-group">
	<table class="table table-bordered">
	<thead>
		<tr>
		<th>#</th>
		<th>Name</th>
		<th>Phone</th>
		<th>Booking Start</th>
		<th>Booking End</th>
		<th>Team Name</th>
		<th>Status</th>
		</tr>
	<thead>
	<tbody>
		<?php 
		$app = get_status();
		//print_r($app);
		$n=0;
		foreach($app as $b){
			$n++;
			 if ($b['status_booking'] == 1){
				$status = "<span class='glyphicon glyphicon-ok' title='Approved'></span>";
				$update = "";
			}else{
				$status = "<span class='glyphicon glyphicon-remove' title='Not Approved Yet'></span>";
				$update = "<a href='#' onclick='update_booking(".$b['id_booking'].")'>Approve</a>";
			}
			
			echo "<tr> <td>".$n.".</td>
						<td>".$b['name']."</td>
						<td>".$b['phone']."</td>
						<td>".$b['start_play']."</td>
						<td>".$b['end_play']."</td>
						<td>".$b['team_name']."</td>
						<td>".$status."  ".$update."</td>
				</tr>";
		}
		?>
	</tbody>
	</table>
	
</div>
	<script type="text/javascript">
		function update_booking(id){
		x = confirm('Approve this booking ?');
		if(x == true){
			window.location='?approved=true&id='+id;
		}
	}
	
	</script>
