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
			<h1 class="page-title text-center">Member</h1>
			<hr>
			<table class="table table-bordered">
			<thead>
				<tr>
				<th>#</th>
				<th>Name</th>
				<th>Courses</th>
				<th>Email</th>
				<th>Member Status</th>
				</tr>
			<thead>
			<tbody>
				<?php 
				$app = get_member();
				$n=0;
				foreach($app as $b){
					if ($b['status'] == 1){
						$status = "<span class='glyphicon glyphicon-ok' title='Active'></span>";
					}else{
						$status = "<span class='glyphicon glyphicon-remove' title='Not Active'></span>";
					}
					$n++;					
					echo "<tr> <td>".$n.".</td>
							<td>".$b['name']."</td>
							<td>".$b['course']."</td>
							<td>".$b['email']."</td>
							<td>".$status."</td>
						</tr>";
				}
				?>
			</tbody>
			</table>
		</div>
</div>
