<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{	
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<div class="box" style="width:85%">
<?php
$setTable	= "activity";
if(isset($_GET['insert'])){
	$params	= $_POST;
	insert($setTable, $params);
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
	$applicant = get_data($setTable,$id);
	?>
	<form class="form-horizontal" id="update-form" method="post">
	<input type="hidden" name="id" value="<?php echo $id ?>">
		<div class="form-group">
		<label class="control-label col-xs-12"><h4 class="title"><?php echo $content['title'] ?></h4></label>
		</div>

		<div class="form-group">
		<label class="control-label col-xs-4" for="details">Details</label>
		<div class="col-xs-8"><textarea class="form-control" id="details" name="details" tabindex="1" required><?php echo $applicant['details'] ?></textarea></div>
		</div>

		<div class="form-group">
		<label class="control-label col-xs-4" for="name">Activity Name</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="name" name="name" tabindex="1" required value="<?php echo $applicant['name'] ?>"></div>
		</div>

		<div class="form-group">
		<label class="control-label col-xs-4" for="course">Activity Role</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="course" name="role" tabindex="1" required  value="<?php echo $applicant['role'] ?>"></div>
		</div>

		<div class="form-group">
		<label class="control-label col-xs-4" for="matric">Point</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="matric" name="point" tabindex="1"  required  value="<?php echo $applicant['point'] ?>"></div>
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
		<label class="control-label col-xs-4" for="details">Details</label>
		<div class="col-xs-8"><textarea class="form-control" id="details" name="details" tabindex="1" required></textarea></div>
		</div>

		<div class="form-group">
		<label class="control-label col-xs-4" for="name">Activity Name</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="name" name="name" tabindex="1" required></div>
		</div>

		<div class="form-group">
		<label class="control-label col-xs-4" for="course">Activity Role</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="role" name="role" tabindex="1" required ></div>
		</div>

		<div class="form-group">
		<label class="control-label col-xs-4" for="matric">Point</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="point" name="point" tabindex="1"  required"></div>
		</div>

		<div class="form-group">
			<div class="buttonreg">
				<button type="button" class="btn btn-danger" id="cancel" onclick="javascript:self.history.back()">Cancel</button>
				<button type="submit" class="btn btn-primary" id="register">Save</button>
			</div>
		</div>	
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

else{
?>
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

	<table class="table table-bordered">
	<thead>
		<tr>
		<th>Name</th>
		<th>Role</th>
		<th>Point</th>
		<th>Edit</th></tr>
	<thead>
	<tbody>
		<?php 
		$students = get_data($setTable);
		foreach($students as $stu){
			
			//$status = $stu['status'] == 0 ? "<span class='glyphicon glyphicon-remove' title='Not Active'></span>" : "<span class='glyphicon glyphicon-ok' title='Active'></span>";
			echo "<tr> <td>".$stu['name']."</td>
						<td>".$stu['role']."</td>
						<td>".$stu['point']."</td>
						<td>
							<a href=?edit=true&id=".$stu['id']."><span class='glyphicon glyphicon-edit'></span></a> 
						<!--	 |<a href='#' onclick='applicant_delete(".$stu['id'].")'><span class='glyphicon glyphicon-trash'></span></a>
						</td>-->
				</tr>";
		}
		?>
	</tbody>
	</table>
	<button type="submit" class="btn btn-primary" onclick="window.location='?add=true'">Add Activity</button>
	<button type="button" onclick='window.print()' class="btn btn-primary">PRINT</button>
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
				if(display[1]!="Insert activity data error."){
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
	
});

function applicant_delete(id){
	x = confirm('Delete this Activity data ?');
	if(x == true){
		window.location='?delete=true&id='+id;
	}
}
</script>

<?php
}
?>
