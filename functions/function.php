<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{	
	header("HTTP/1.0 404 Not Found");
	exit();
}

//print_r($config);

function get_header($json = null){
	global $config;
	if($json == null) include $config->config['templates']."header.php";
}

function get_footer($json = null){
	global $config;
	if($json == null) include $config->config['templates']."footer.php";
}

function get_sidebar($json=null){
	global $config;
	include $config->config['templates']."sidebar.php";
}

function get_content($json = null){
	global $config;
	include $config->config['templates']."content_default.php";
}

function login_group(){
	$login = "visitor";
	if(isset($_SESSION['login'])){
		if($_SESSION['login']['groups']==1){
			$login = 'admin';
		}
		if($_SESSION['login']['groups']==2){
			$login = 'user';
		}
		if($_SESSION['login']['groups']==3){
			$login = 'finance';
		}
	}
	return $login;
}

function insert($table,$dataToInsert){
	global $db;
	$id = $db->insert($table, $dataToInsert);
	if($id){
		echo ':::Insert data into '.$table.' has been succeeded.';
	}else{
		echo ':::Insert data Error : '.$db->getLastError();
	}
	exit;
}

function insert_awards($table,$dataToInsert){
	global $db;
	print_r($dataToInsert);
	for($i=0; $i<=sizeof($dataToInsert['id_student']) - 1; $i++){
		$leader = isset($dataToInsert['leader']) ? '1' : '0';
		$id = $db->rawQueryOne("INSERT INTO ".$table." (id_student, id_activity, leader, total_hour) VALUES ('".$dataToInsert['id_student'][$i]."',
																																'".$dataToInsert['id_activity']."',
																																'".$leadera."',
																																'".$dataToInsert['total_hour'][$i]."')");
	}
	
	if($id){
		echo ':::Insert data into '.$table.' has been succeeded.';
	}else{
		echo ':::'.$db->getLastError();
	}
	exit;
}

function get_content2($url){
	global $db;
	//$id = isset($_GET['url']) ? $_GET['url'] : "";
	$db->where ("url", $url);
	$db->where (login_group(), 1);
	$content 	= $db->getOne ("contents");
	return $content;
}

function get_menu_top(){
	global $db, $config;
	$db->where ('category', 1);
	if(get_menu_admin()=='admin'){
		$db->where ('admin', 1);
		//$db->Where ('isLogin', 1);
	}
	elseif(get_menu_admin()=='user'){
		$db->where ('user', 1);
	}
	elseif(get_menu_admin()=='finance'){
		$db->where ('finance', 1);
	}else{
		$db->where ('visitor', 1);
	}
	$db->orderBy("position","asc");
	$menu = $db->get('contents');
	for($i=0;$i<=sizeof($menu)-1;$i++){
		if($menu[$i]['url']=='home'){
			$home = '<i class="fa fa-home"></i>';
		}else{
			$home = '';
		}
		if($menu[$i]['url']==$_GET['url']){
			echo "<li class='selected'><a href=".$config->url.$menu[$i]['url'].">".$home.$menu[$i]['title']."</a></li>";
		}elseif($menu[$i]['url']=="logout()"){
			echo "<li><a onclick=".$menu[$i]['url']." href='#'>".$menu[$i]['title']."</a></li>";
		}
		else{
			echo "<li><a href=".$config->url.$menu[$i]['url'].">".$home.$menu[$i]['title']."</a></li>";
		}
	}
}

function get_menu_admin(){
	$login = "visitor";
	if(isset($_SESSION['login'])){
		if($_SESSION['login']['groups']==1){
			$login = 'admin';
		}
		if($_SESSION['login']['groups']==2){
			$login = 'user';
		}
		if($_SESSION['login']['groups']==3){
			$login = 'finance';
		}
	}
	return $login;
}

function get_menu_right(){
	global $db, $config;
	$db->where ('category', 2);
	if(get_menu_admin()==1){
		$db->where ('admin', 1);
	}
	$menu = $db->get('contents');
	for($i=0;$i<=sizeof($menu)-1;$i++){
		if($menu[$i]['url']==$_GET['url']){
			echo "<li class='subselected'><a href=".$config->url.$menu[$i]['url'].">".$menu[$i]['title']."</a></li>";
		}else{
			echo "<li><a href=".$config->url.$menu[$i]['url'].">".$menu[$i]['title']."</a></li>";
		}
	}
}

function update($table,$field,$id,$params){
	global $db;
	$db->where ($field, $id);
	$update = $db->update ($table, $params);
	if($update){
		echo ":::Update has been successfull:::";
	}else{
		echo ":::".$db->getLastError().":::";
	}
}

function update_awards($table,$where,$params){
	global $db;
	$db->where ("id_activity", $where['id_activity']);
	$db->where ("id_student", $where['id_student']);
	$update = $db->update ($table, $params);
	if($update){
		echo ":::Update has been successfull:::";
	}else{
		echo ":::".$db->getLastError().":::";
	}
}
  
function update_table($table, $data, $id_value) {
	global $db;
	$db->where ('id', $_SESSION['login'][0]['id']);
	if ($db->update ($table, $data)){
		echo ':::Data updated';
	}
	else{
		echo ':::Data update failed: ' . $db->getLastError();
	}
	//echo $db->getLastQuery();
}

function get_month_list($sameMonth=null){
	for($i=1;$i<=12;$i++){
		$monthName[$i] = date('F', mktime(0, 0, 0, $i, 10));
		$m = date('m', mktime(0, 0, 0, $i, 10));
		if($sameMonth==$m){
			echo "<option value=$m selected>$monthName[$i]</option>";
		}else{
			echo "<option value=$m>$monthName[$i]</option>";
		}
	}
}
  
function get_year_list($year=null){
	for($i=2012;$i<=date('Y')+1;$i++){
		if($year==$i){
			echo "<option value=$i selected>$i</option>";
		}else{
			echo "<option value=$i>$i</option>";
		}
	}
} 
  
function insert_table($table,$data){
	global $db;
	/*$params['employee_id'] 	= $data['employee_id'];
	$params['ic_no'] 		= $data['ic_no'];
	$params['email'] 		= $data['email'];*/
	$id = $db->insert($table, $params);
	if($id){
		$user	= array('username'=>$data['email'],'password'=>md5($data['password']), 'groups'=>2);
		$db->insert('users',$user);
		echo ':::Registration Success.';
	}else{
		echo ':::Registration Error : '.$db->getLastError();
	}
	exit;
}

function insert_chat($table,$data){
	global $db;
	$id = $db->insert($table, $data);
	exit;
}

function registration($table,$data){
	global $db;
	$params['name'] 		= $data['name'];
	$params['course'] 	= $data['course'];
	$params['email'] 		= $data['email'];
	$params['phone'] 	= $data['phone'];
	$params['matric'] 	= $data['matric'];
	$params['campus'] 	= $data['campus'];
	$id = $db->insert($table, $params);
	if($id){
		$user	= array('username'=>$data['matric'],'password'=>md5($data['password']), 'groups'=>2,'student_id'=>$db->getInsertId());
		$db->insert('users',$user);
		echo ':::Registration Success.';
	}else{
		echo ':::Registration Error : '.$db->getLastError();
	}
}

function view_invoice($id){
	global $db;
	$db->where("id_booking",$id);
	$booking = $db->getOne("booking");
	return $booking;
}

function insert_booking($table,$data){
	global $db;
	$startplay = $data['start_play'];
	$endplay = $data['end_play'];
	$checkbooking = $db->rawQueryOne ('SELECT id_booking FROM booking WHERE 
									(start_play <= "'.$startplay.'" AND end_play >= "'.$startplay.'") OR
									   (start_play <= "'.$endplay.'" AND end_play >= "'.$endplay.'") OR
									   (start_play >= "'.$startplay.'" AND end_play <= "'.$endplay.'")');
	if($checkbooking['id_booking'] > 0){
		echo ":::Sorry, Booking is not available for selected Date and Time, Please try other date and time:::0";
	}else{
		$id = $db->insert($table, $data);
		if($id){
			echo ':::Booking Success.:::1:::'.$id;
		}else{
			echo ':::Booking Error:::'.$db->getLastError();
		}
	}
	exit;
}

function class_admin(){
	$class = array();
	$class = array('class'=>'','button'=>'');
	if(isset($_SESSION['login'])){
		if($_SESSION['login'][0]['groups']==1){
		$class = array('class'=>"class='editable'",'button'=>"<button type='submit' id='update' class='btn btn-primary'> &nbsp; UPDATE &nbsp; </button>");
		}
	}
	return $class;
}

function cek_login($username,$password){
	global $db;
	if(strlen($username) > 0 && strlen($password) > 0){
		$username	= strtolower($username);
		$password	= md5($password);
		$db->where('username',$username);
		$db->where('password',$password);
		$results = $db->getOne ('users');
		if(sizeof($results) > 0){
			$_SESSION['login']	= $results;
			$db->where('id',$results['student_id']);
			$login_data 		= $db->getOne('students');
			if(sizeof($login_data) > 0){
				$_SESSION['login']	= array_merge($results,$login_data);
				
				if($_SESSION['login']['status'] == 0) {
					echo ":::Login Error.:::";
					unset($_SESSION['login']);
					//exit;
				}
			}
			if ($_SESSION['login']['groups'] == "1"){
					echo ":::manage-students";
				}
				if($_SESSION['login']['groups'] == "2"){
					echo ":::profile";
				}

		}else{
			echo ":::Login Error.:::";
		}
	}
	exit;
}

if(isset($_GET['logout'])){
	logout();
}

function logout(){
	global $config;
	if(isset($_SESSION['login'])){
		unset($_SESSION['login']);
		session_destroy();
	}
	echo "<script>window.location='".$config->url."';</script>";
}

function get_student($id=null, $status=null, $campus=null){
	global $db;
	
	if($_SESSION['login']['username'] == 'adminbt'){
		$db->where("campus",1);
	}
	
	if($_SESSION['login']['username'] == 'adminsa'){
		$db->where("campus",2);
	}
	
	if($status) $db->where("status",$status);
	if($campus) $db->where("campus",$campus);
	
	if(strlen($id) > 0){
		$db->where("id",$id);
		$results = $db->getOne('students');
	}else{
		$results = $db->get ('students');
	}
	return $results;
}

function get_data($table,$id=null){
	global $db;
	if($table == "students") $db->where("status",1);
	if(strlen($id) > 0){
		$db->where("id",$id);
		$results = $db->getOne($table);
	}else{
		$results = $db->get ($table);
	}
	return $results;
}

function get_data_awards($id=null, $studentId=null){
	global $db;
	if(!empty($studentId)){
		$db->where("p.id_student", $studentId);
	}
	
	if(!empty($id)){
		$db->where("p.id_activity", $id);
	}
	
	if(empty($id) && empty($studentId)){
			$db->groupBy("p.id_student");
			$db->orderBy("total_point");
	}
	
		$db->join("students s", "p.id_student=s.id", "LEFT");
		$db->join("activity a", "p.id_activity=a.id", "LEFT");
		$results = $db->get ("awards p", null, "*, s.name as student_name, (case when p.leader=1 then (p.total_hour * a.point) + 2 ELSE p.total_hour * a.point END) as total_points");	
		return $results;
}

function get_status($id=null){
	global $db;
	$db->join("students B", "A.student_id=B.id");
	//$db->join("users E", "A.approve1_by=E.id", "LEFT");
	if(strlen($id) > 0){
		//$db->join("claim_mileage C", "A.applicant_id=C.applicant_id");
		//$db->join("claim_expenses D", "C.applicant_id=D.applicant_id");
		$db->where("A.student_id",$id);
	}
	$results = $db->get ('booking A');
	//echo $db->getLastQuery();
	return $results;
}

function get_team($id=null){
	global $db;
	$cols = Array ("*", "count(*) as total_booking");
	$db->join("students B", "A.student_id=B.id");
	$db->groupBy("A.team_name");
	//$db->join("users E", "A.approve1_by=E.id", "LEFT");
	if(strlen($id) > 0){
		//$db->join("claim_mileage C", "A.applicant_id=C.applicant_id");
		//$db->join("claim_expenses D", "C.applicant_id=D.applicant_id");
		$db->where("A.student_id",$id);
	}
	$results = $db->get ('booking A',null,$cols);
	//echo $db->getLastQuery();
	return $results;
}

function get_member($id=null){
	global $db;
	$results = $db->get ('students');
	return $results;
}

function delete($table,$id,$field=null){
	global $db;
	if($field==null) $field = "id";
	$db->where($field,$id);
	if($db->delete($table)) return true;
}

function get_news_info($id = null){
	global $db;
	$db->orderBy ('title', 'ASC');
	if($id != ""){
		$db->where('id_news', $id);
	}
	return $news_info = $db->get('news_info');
}

function get_campus($id = null){
	global $db;
	$campus = "Volunter";
	if($id ==1)	$campus = "Bestari Jaya";
	if($id ==2)	$campus = "Shah Alam";
	return $campus;
}


function news_info_edit($id=null){
	global $db;
	if(isset($id)) {
		$db->where('id_news', $id);
		$reserv = $db->getOne('news_info');
	}
	//print_r($reserv);
	//$contents = explode(":::",$reserv['content']);
	?>
		<div class="col-lg-12">
		<div id="message"></div>
</div>
<div id="package_edit">
						<form role="form" method="post" id="package_form" novalidate>
							<input type="hidden" name="id_news" value="<?= isset($reserv['id_news']) ? $reserv['id_news'] : "" ?>">
							<div class="col-lg-12">
								<div id="message"></div>
							</div>
							<div class="form-group">
									<label for="title">Title</label>
									<div class="input-group">
										<input type="text" class="form-control" name="title" id="title" required value="<?= isset($reserv['title']) ? $reserv['title'] : "" ?>">
										<span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
									</div>
								</div>
								<div class="form-group">
									<label for="content">Content</label>
									<div class="input-group">
										<textarea name="content" id="content" class="form-control" rows="10" required><?= isset($reserv['content']) ? $reserv['content'] : "" ?></textarea>
										<span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
									</div>
								</div>
								
								<div class="form-group col-lg-3">
									<label for="category">Category</label>
									<div class="input-group">
										<?php $status = array('1'=>'News','2'=>'Info');
										?>
										<select name="category" class="form-control">
										<?php
										foreach($status as $q => $val){
											if($q == $reserv['cat']){
												echo "<option value=".$q." selected>".$val."</option>";
											}else{
												echo "<option value=".$q." >".$val."</option>";
											}
										}
										?>
										</select>
										<span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
									</div>
								</div>
								
								<div class="form-group col-lg-3">
									<label for="status">Status</label>
									<div class="input-group">
										<?php $status = array('0'=>'Draft','1'=>'Published');
										?>
										<select name="status" class="form-control">
										<?php
										foreach($status as $q => $val){
											if($q == $reserv['visitor']){
												echo "<option value=".$q." selected>".$val."</option>";
											}else{
												echo "<option value=".$q." >".$val."</option>";
											}
										}
										?>
										</select>
										<span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
									</div>
								</div>
							</div>
								
						<hr />
							<button type="submit" name="submit" id="submit" class="btn btn-primary col-xs-2">UPDATE</button>
							<button type="button" name="cancel" id="cancel" class="btn btn-default col-xs-2" onclick="self.history.back()">CANCEL</button>
							</div>
						</form>
		
	</div>
</form>
	
<?php
}

?>
