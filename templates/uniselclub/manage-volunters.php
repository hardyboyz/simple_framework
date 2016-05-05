<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{	
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<div class="box" style="width:85%">
<?php
$setTable	= "students";
if(isset($_GET['add_student'])){
	$params	= $_POST;
	$params['applicant_id']	= $_SESSION['login']['1']['student_id'];
	insert_applicant($setTable,$params);
	exit;
}

if(isset($_GET['delete'])){
	delete($setTable,(int)$_GET['id'],"id");
	exit;
}

if(isset($_GET['update'])){
	$params = $_POST;
	update($setTable,"id",(int)$_POST['id'],$params);
	exit;
}

if(isset($_GET['edit'])){
	$id = (int)$_GET['id'];
	$applicant = get_student($id);
	?>
	<form class="form-horizontal" id="update-form" method="post">
	<input type="hidden" name="id" value="<?php echo $id ?>">
		<div class="form-group">
		<label class="control-label col-xs-12"><h4 class="title">Personal Details</h4></label>
		</div>

		<div class="form-group">
		<label class="control-label col-xs-4" for="name">Name</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="name" name="name" tabindex="1" required value="<?php echo $applicant['name'] ?>"></div>
		</div>

		<div class="form-group">
		<label class="control-label col-xs-4" for="course">Course</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="course" name="course" tabindex="1" required  value="<?php echo $applicant['course'] ?>"></div>
		</div>

		<div class="form-group">
		<label class="control-label col-xs-4" for="matric">Matric Card No.</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="matric" name="matric" tabindex="1"  disabled  value="<?php echo $applicant['matric'] ?>"></div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4" for="email">Email</label>
			<div class="col-xs-8"><input type="email" class="form-control" id="email" name="email" tabindex="1" required value="<?php echo $applicant['email'] ?>"></div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-xs-4" for="phone">Phone</label>
			<div class="col-xs-8"><input type="text" class="form-control" id="phone" name="phone" tabindex="1" required value="<?php echo $applicant['phone'] ?>"></div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-xs-4" for="status">Status</label>
			<div class="col-xs-8"><select name="status" class="form-control">
			<?php
				$status = array(0=>"Not Active",1=>"Active");
				foreach($status as $i =>$val){
						if($i == $applicant['status']){
							echo "<option selected value='".$i."'>".$val."</option>";
					}else{
							echo "<option value='".$i."'>".$val."</option>";
					}
				}
			?>
			</select>
			</div>
		</div>

		<div class="form-group">
			<div class="buttonreg">
				<button type="button" class="btn btn-danger" id="cancel" onclick="javascript:self.history.back()">Cancel</button>
				<button type="submit" class="btn btn-primary" id="register">Update</button>
			</div>
		</div>	
		<hr>
		</form>
		
<script>
$(document).ready(function(){
	$("form#update-form").submit(function() {	
	$('#register').attr('disabled','disabled');
	$('#register').html('Updating your data. Please wait...');
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
				window.location='manage-students';
			},
			
		});
	return false;
	});
});
</script>
	
	<?php
}

else{
?>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
	<style type="text/css" media="print">
		#sidebar-wrapper {
			display:none;
	}
		.btn {
			display:none;
		}
	</style>
	<div style="padding-top:12px">
		<h4 class="title"><?php echo $content['title'] ?></h4>
	</div>

	<table class="table table-bordered" id="manage-students">
	<thead>
		<tr>
		<th>Name</th>
		<!--<th>Campus</th>
		<th>MatricNo.</th>
		<th>Course</th>-->
		<th>Email</th>
		<th>Phone</th>
		<th>Status</th>
		<th>_</th></tr>
	<thead>
	<tbody>
		<?php 
		$students = get_student(null,null,3);
		foreach($students as $stu){
			$campus = get_campus($stu['campus']);
			$status = $stu['status'] == 0 ? "<span class='glyphicon glyphicon-remove' title='Not Active'></span>" : "<span class='glyphicon glyphicon-ok' title='Active'></span>";
			echo "<tr style='background-color:#000'> <td>".$stu['name']."</td>
						<!--<td>".$campus."</td>
						<td>".$stu['matric']."</td>
						<td>".$stu['course']."</td>-->
						<td>".$stu['email']."</td>
						<td>".$stu['phone']."</td>
						<td>".$status."</td>
						<td>
							<a href=?edit=true&id=".$stu['id']."><span class='glyphicon glyphicon-edit'></span></a> 
						<!--	 |<a href='#' onclick='applicant_delete(".$stu['id'].")'><span class='glyphicon glyphicon-trash'></span></a>
						</td>-->
				</tr>";
		}
		?>
	</tbody>
	</table>
	<button type="button" onclick='window.print()' class="btn btn-primary">PRINT</button>
</div>
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" type="text/javascript"> </script>

<script>
$(document).ready(function(){
	$('#manage-students').DataTable();
	$("form[id=frm-applicant]").submit(function() {
		$.ajax({
			type: "POST",
			url: "?add_student=true",
			data: $('form[id=frm-applicant]').serialize(),
			success: function(info){
				display	= info.split(":::");
				if(display[1]!="Student added Error"){
					window.location='manage-students';
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
	
});

function applicant_delete(id){
	x = confirm('Delete this student data ?');
	if(x == true){
		window.location='?delete=true&id='+id;
	}
}
</script>

<?php
}
?>
