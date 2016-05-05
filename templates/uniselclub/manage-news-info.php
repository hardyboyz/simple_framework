<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<link href="<?php echo $config->url.$config->config['plugins'] ?>jquerydatatable/jquery.dataTables.css" rel="stylesheet">
<script src="<?php echo $config->url.$config->config['plugins'] ?>jquerydatatable/jquery.dataTables.min.js"></script>
<script src="<?php echo $config->url.$config->config['plugins'] ?>tinymce/tinymce.min.js"></script>
<script> 
	$(function() {   
	  tinyMCE.init({selector: '#content', 
						plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern imagetools"
    ],
					  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons", file_browser_callback: RoxyFileBrowser}); 
	});
	function RoxyFileBrowser(field_name, url, type, win) {
	  var roxyFileman = '<?php echo $config->url.$config->config['plugins'] ?>fileman/index.html';
	  if (roxyFileman.indexOf("?") < 0) {     
		roxyFileman += "?type=" + type;   
	  }
	  else {
		roxyFileman += "&type=" + type;
	  }
	  roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
	  if(tinyMCE.activeEditor.settings.language){
		roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
	  }
	  tinyMCE.activeEditor.windowManager.open({
		 file: roxyFileman,
		 title: 'Roxy Fileman',
		 width: 850, 
		 height: 650,
		 resizable: "yes",
		 plugins: "media",
		 inline: "yes",
		 close_previous: "no"  
	  }, {     window: win,     input: field_name    });
	  return false; 
	}
</script>
<script>
		$(document).ready(function() {
			$('#reservation_list').dataTable();
		} );
</script>
<div id="message"></div>
<div class="box" style="width:85%">
<?php
if(isset($_GET['action'])){
		$table = "news_info";
		$action = $_GET['action'];
		if($action ===  "update" ) {
			$params = array();
			$params = $_POST;
			if($params['id_news'] == ""){
				insert($table,$params);
			}else{
				update($table, "id_news",$params['id_news'],$params);
			}
		}
		
		else if($action ===  "delete" ) {
			if(delete($table, $_GET['id'],"id_news")){
				echo "<script>window.location=".$_SERVER['HTTP_REFERER']."</script>";
			}
			
		}
		
		else if($action ===  "edit" ) {
			news_info_edit($_GET['id']);
		}
		
		else if($action ===  "add" ) {
			news_info_edit();
		}
		
		else if($action ===  "delete" ) {
			delete($_GET['id']);
		}
		
}else{
?>
<table id="news_info_list" class="table" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Category</th>
			<th>Title</th>
			<th>_</th>
		</tr>
	</thead>
	<tbody>
<?php $package = get_news_info() ;
			$i = 0;
			foreach ($package as $res){
				$i++;
				if($res['category'] == 1){
					$cat = "News";
				}
				if($res['category'] == 2){
					$cat = "Info";
				}
			
				echo "<tr>
							<td>".$cat."</td>
							<td>".$res['title']."</td>
					<td>";
				echo	"<a href='?action=edit&id=".$res['id_news']."'><img src=".$config->config['templates']."images/edit.png width='20px'></a> ";
				echo	"<a href='#' onclick=\"delete_news('".$res['id_news']."')\"><img src=".$config->config['templates']."images/del.png width='20px'></a> 
					</td>
				</tr>";
			}
?>
</tbody>
</table>
<button type="button" name="add_news_info" id="news_info" class="btn btn-primary col-xs-4" onclick="window.location='?action=add'">ADD NEWS & INFO</button>
<?php
}
?>

</div>
</div>
<script>
		
	$(document).ready(function(){
		$("form#package_form").submit(function() {	
			$('#submit').attr('disabled','disabled');
			$('#submit').html('Updating your content, please wait...');
			tinyMCE.triggerSave();
				$.ajax({
					type: "POST",
					url: "?action=update",
					data: $('form[id=package_form]').serialize(),
					success: function(info){
						//alert(info);
						data = info.split(":::");
						//console.log(info);
						$('#message').html('<div class="alert alert-success"><strong><span class="glyphicon glyphicon-ok"></span> Your content has been Updated.</strong></div>');
						
						/*setTimeout(function(){
							window.location.reload();
						}, 3000);*/
						//$('#add').removeAttr('disabled');
						//$('#add').html('Update');
						$('#submit').removeAttr('disabled');
						$('#submit').html('Update');
					},
					
				});
			return false;
		});
	});
	</script>
	<script>
		function delete_news(id){
			x = confirm ('Delete this data?');
			if(x==true){
				window.location='?action=delete&id='+id;
			}
		}
	</script>
	</div>

	<?php get_footer(); ?>
