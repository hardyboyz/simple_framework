<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<div class="alert alert-info" id="register_success" style="display:none"></div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-title text-center">List Team</h1>
			<hr>
			<table class="table table-bordered">
			<thead>
				<tr>
				<th>#</th>
				<th>Team Name</th>
				<th>Team Leader</th>
				<th>Total Booking</th>
				</tr>
			<thead>
			<tbody>
				<?php 
				$app = get_team();
				$n=0;
				foreach($app as $b){
					$n++;					
					echo "<tr> <td>".$n.".</td>
								<td>".$b['team_name']."</td>
								<td>".$b['name'].' &raquo; '.$b['course']."</td>
								<td>".$b['total_booking']."</td>
						</tr>";
				}
				?>
			</tbody>
			</table>
		</div>
</div>
