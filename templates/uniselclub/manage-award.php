<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{	
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<div class="box" style="width:85%">
<?php
$setTable	= "awards";
if(isset($_GET['insert'])){
	$params	= $_POST;
	insert_awards($setTable, $params);
	exit;
}

if(isset($_GET['delete'])){
	delete($setTable,(int)$_GET['id'],"id_activity");
	echo "<script>window.location='manage-award';</script>";
	exit;
}

if(isset($_GET['update'])){
	//$params = $_POST;
	$params['total_hour'] = $_POST['total_hour'];
	$params['leader'] = $_POST['leader'];
	$where['id_activity'] = $_POST['id_activity'];
	$where['id_student'] = $_POST['id_student'];
	update_awards($setTable,$where,$params);
	exit;
}

if(isset($_GET['edit'])){
	$id_activity = (int)$_GET['id_activity'];
	$id_student = (int)$_GET['id_student'];
	//$applicant = get_data($setTable,$id);
	?>
	<form class="form-horizontal" id="update-form" method="post">
		<div class="form-group">
		<label class="control-label col-xs-12"><h4 class="title"><?php echo $content['title'] ?></h4></label>
		</div>
		
		<div class="form-group">
		<label class="control-label col-xs-8" for="id_activity">Activity Name</label>
		<div class="col-xs-4">
		<select name="id_activity" class="form-control" id="id_activity">
			<?php
				$activity = get_data("activity");
				foreach($activity as $act){
						$selected = $_GET['id_activity'] == $act['id'] ? "selected" : "";
						echo "<option value=".$act['id']." $selected>".$act['name']."</option>";
				}
			?>
		</select>
		</div>
		
		<table class="table table-hovered">
		<thead>
			<tr>
			<th>Leader</th>
			<th>Name</th>
			<th>Total Hour</th>
		<thead>
		<tbody>
			<?php 
			$id_activity = isset($_GET['id_activity'])  ? $_GET['id_activity'] : 0;
			$id_student = isset($_GET['id_student'])  ? $_GET['id_student'] : 0;
			$students = get_data_awards($id_activity, $id_student);
			foreach($students as $stu){
				//$status = $stu['status'] == 0 ? "<span class='glyphicon glyphicon-remove' title='Not Active'></span>" : "<span class='glyphicon glyphicon-ok' title='Active'></span>";
				echo "<tr> 
							<td><input type='radio' name='leader' value='1'></td>
							<td>".$stu['student_name']."</td>
							<td><input type='text' name='total_hour' class='form-control col-md-2' value=".$stu['total_hour']."></td>
							<td></td>
					</tr>";
			}
			?>
		</tbody>
		</table>
		<button type="submit" class="btn btn-primary">Update <?php echo ucfirst($setTable) ?></button>
			<hr>
		<input type="hidden" name="id_activity" value="<?php echo $id_activity ?>">
		<input type="hidden" name="id_student" value="<?php echo $id_student ?>">
		</form>
		
		<script>
		$(document).ready(function(){
			$("form#update-form").submit(function() {	
			$('#register').attr('disabled','disabled');
			$('#register').html('Create new activity. Please wait...');
				$.ajax({
					type: "POST",
					url: "?update=true",
					data: $('form[id=update-form]').serialize(),
					success: function(info){
						display	= info.split(":::");
						alert(display[1]);
						$('#register_success').fadeIn(1000);
						$('#register_success').text(display[1]);
						//$('#register-form').slideUp();
						//$('#register').removeAttr('disabled');
						$('#register').text(display[1]);
						window.location='<?php echo $content['url'] ?>';
					},
					
				});
			return false;
			});
		});
		</script>
	
	<?php
}

else if(isset($_GET['add'])){
	?>
	<form class="form-horizontal" id="new-form" method="post">
		<div class="form-group">
		<label class="control-label col-xs-12"><h4 class="title"><?php echo $content['title'] ?></h4></label>
		</div>
		
		<div class="form-group">
		<label class="control-label col-xs-8" for="id_activity">Activity Name</label>
		<div class="col-xs-4">
		<select name="id_activity" class="form-control" id="id_activity">
			<?php
				$activity = get_data("activity");
				foreach($activity as $act){
						$selected = $_GET['id_activity'] == $act['id'] ? "selected" : "";
						$point = $activity['point'];
						echo "<option value=".$act['id']." $selected data-point=".$act['point'].">".$act['name']."</option>";
				}
			?>
		</select>
		</div>
		
		<table class="table table-hovered">
		<thead>
			<tr>
			<th>Leader</th>
			<th>Name</th>
			<th>Total Hour</th>
		<thead>
		<tbody>
			<?php 
			$id_activity = isset($_GET['id_activity'])  ? $_GET['id_activity'] : 0;
			$students = get_data("students");
			foreach($students as $stu){
				
				//$status = $stu['status'] == 0 ? "<span class='glyphicon glyphicon-remove' title='Not Active'></span>" : "<span class='glyphicon glyphicon-ok' title='Active'></span>";
				echo "<tr> 
							<td><input type='radio' name='leader[]' value='1'></td>
							<td><input type='hidden' name='id_student[]' value=".$stu['id'].">".$stu['name']."</td>
							<td><input type='text' name='total_hour[]' class='form-control col-md-2'></td>
							<td></td>
					</tr>";
			}
			?>
		</tbody>
		</table>
		<button type="submit" class="btn btn-primary">Submit <?php echo ucfirst($setTable) ?></button>
			<hr>
		</form>
		
<script>
$(document).ready(function(){
	$("form#new-form").submit(function() {	
	$('#register').attr('disabled','disabled');
	$('#register').html('Create new activity. Please wait...');
		$.ajax({
			type: "POST",
			url: "?insert=true",
			data: $('form[id=new-form]').serialize(),
			success: function(info){
				display	= info.split(":::");
				if(display[1] == ""){
					alert('Insert data awards has been succesfully');
				}else{
					alert(display[1]);
				}
				$('#register_success').fadeIn(1000);
				$('#register_success').text(display[1]);
				//$('#register-form').slideUp();
				//$('#register').removeAttr('disabled');
				$('#register').text(display[1]);
				window.location='<?php echo $content['url'] ?>';
			},
			
		});
	return false;
	});
	
	$("#id_activity").change(function(){
			window.location='?add=true&id_activity='+$("#id_activity").val();
	});
	
});
</script>
	
	<?php
}

else{
?>
	<div style="padding-top:12px">
		<h4 class="title"><?php echo $content['title'] ?></h4>
	</div>

	<form class="form-horizontal">
	<div class="form-group">
		<label class="control-label col-xs-8" for="id_activity">Activity Name</label>
		<div class="col-xs-4">
		<select name="id_activity" class="form-control" id="id_activity">
			<?php
				$activity = get_data("activity");
				foreach($activity as $act){
						$selected = $_GET['id_activity'] == $act['id'] ? "selected=true" : "";
						echo "<option value=".$act['id']." $selected>".$act['name']."</option>";
				}
			?>
		</select>
		</div>

	<table class="table table-bordered">
	<thead>
		<tr>
		<th>Activity Name</th>
		<th>Role</th>
		<th>Name</th>
		<th>Point</th>
		<th>_</th></tr>
	<thead>
	<tbody>
		<?php 
		$id_activity = isset($_GET['id_activity']) ? $_GET['id_activity'] : 1;
		$students = get_data_awards($id_activity);
			foreach($students as $stu){
				$leader = $stu['leader'] == 1 ? '<a title="The Leader">  <span class="glyphicon glyphicon-star"></span></a>' : '';
				//$status = $stu['status'] == 0 ? "<span class='glyphicon glyphicon-remove' title='Not Active'></span>" : "<span class='glyphicon glyphicon-ok' title='Active'></span>";
				echo "<tr> <td>".$stu['name']."</td>
							<td>".$stu['role']."</td>
							<td>".$stu['student_name'].$leader."</td>
							<td>".$stu['total_points']."</td>
							<td>
								<a href=?edit=true&id_activity=".$id_activity."&id_student=".$stu['id_student']."><span class='glyphicon glyphicon-edit'></span></a> 
							<!--<a href='#' onclick='applicant_delete(".$id_activity.")'><span class='glyphicon glyphicon-trash'></span></a>-->
							</td>
					</tr>";
			}
		?>
	</tbody>
	</table>
	<button type="button" class="btn btn-primary" onclick="window.location='?add=true&id_activity=1'">Add <?php echo ucfirst($setTable) ?></button>
	</form>
</div>
<script>
$(document).ready(function(){
	$("form[id=frm-applicant]").submit(function() {
		$.ajax({
			type: "POST",
			url: "?add_student=true",
			data: $('form[id=frm-applicant]').serialize(),
			success: function(info){
				display	= info.split(":::");
				if(display[1]!="Insert <?php echo $setTable ?> data error."){
					window.location='<?php echo $content['url'] ?>';
				}else{
					alert(display[1]);
					return false;
				}
			}			
		});
	return false;
	});
	
	$("#add").click(function(){
		$("#applicant_add").toggle(500);
	});
	
	$("#id_activity").change(function(){
			window.location='?id_activity='+$("#id_activity").val();
	});
	
});

function applicant_delete(id){
	x = confirm('Delete this <?php echo $setTable ?> data ?');
	if(x == true){
		window.location='?delete=true&id='+id;
	}
}
</script>

<?php
}
?>
