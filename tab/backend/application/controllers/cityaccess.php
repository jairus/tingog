<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cityaccess extends CI_Controller {
	var $admin;
	var $sms;
	var $citymodel;
	var $report;
	public function __construct(){
		//load initial models and libraries that are needed for the controller
		parent::__construct();
		$this->load->database();
		$this->load->model("cityaccess_model");
		$this->load->model("admin_model");
		$this->load->model("sms_model");
		$this->load->model("report_model");
		
		$this->citymodel = new Cityaccess_Model();
		$this->admin = new Admin_Model();
		$this->sms = new SMS_Model();
		$this->report = new Report_Model();
		
		$this->load->helper("functions_helper");
	}
	
	public function index(){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}
		$data = array();
		$data['page_title'] = 'Dispatcher\'s Dashboard &raquo; Reports';
		if(checkPermission(get_class($this), __FUNCTION__)){
			$result = $this->citymodel->getTicketList('new');
			$data['total_new'] = count($result);
			$content = array();
			$content['content'] = $this->load->view('cityaccess/dashboard', $data, TRUE);
			$this->load->view('layout/main', $content);
			#pre($data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function checkTicketMsg($id){
		$result = $this->citymodel->ticketMessages($id);
		foreach($result as $k=>$r){
			if($r['read']==0){
				$unread = true;
			}
		}
		
		if(isset($unread)) return true;
		else return false;
	}
	
	function viewTicketList(){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}
		
		$this->admin->verifyClosedTicket();
		
		$data = array();
		$result = $this->citymodel->getTicketList('new');
		$data['new_tickets'] = $result;
		#$array_tag = array_tag();
		
		$result = $this->citymodel->getTicketList('dispatched');
		$array = array();
		$i=0;
		foreach($result as $k=>$v){
			if(isset($v['department'])){
				$d = std2arr($this->admin->getDepartments($v['department']));
				$v['department'] = $d[0]['department'];
			}
			
			if(isset($v['barangay']) && $v['barangay']){
				$brgy = $this->admin->getBarangay($v['barangay']);
				$v['barangay'] = $brgy[0]['name'];
			}else{
				$v['barangay'] = "";
			}
			
			$v['read'] = $this->checkTicketMsg($v['id']);
			
			array_push($array,$v);
		}
		#pre($result);
		$data['dispatched_tickets'] = $array;
		
		$result = $this->citymodel->getTicketList('returned');
		$array = array();
		$i=0;
		foreach($result as $k=>$v){
			if(isset($v['department'])){
				$d = std2arr($this->admin->getDepartments($v['department']));
				$v['department'] = $d[0]['department'];
			}
			
			if(isset($v['barangay']) && $v['barangay']){
				$brgy = $this->admin->getBarangay($v['barangay']);
				$v['barangay'] = $brgy[0]['name'];
			}else{
				$v['barangay'] = "";
			}
			
			$v['read'] = $this->checkTicketMsg($v['id']);
			
			array_push($array,$v);
		}
		$data['returned_tickets'] = $array;
		
		$data['new_tickets'] = array_merge($data['new_tickets'], $data['returned_tickets']);
		
		$result = $this->citymodel->getTicketList('parked');
		$array = array();
		$i=0;
		foreach($result as $k=>$v){
			#pre($v);
			if(isset($v['barangay']) && $v['barangay']){
				$brgy = $this->admin->getBarangay($v['barangay']);
				$v['barangay'] = $brgy[0]['name'];
			}else{
				$v['barangay'] = "";
			}
			
			$v['read'] = $this->checkTicketMsg($v['id']);
			
			array_push($array,$v);
		}
		$data['parked_tickets'] = $array;
		
		$result = $this->citymodel->getTicketList('closed');
		$array = array();
		$i=0;
		foreach($result as $k=>$v){
			if(isset($v['department'])){
				$d = std2arr($this->admin->getDepartments($v['department']));
				$v['department'] = $d[0]['department'];
			}
			if(isset($v['assign1'])){
				$d = std2arr($this->admin->getPersonnel($v['assign1']));
				if(count($d)) $v['assign1'] = $d[0]['person'];
				else $v['assign1'] = "";
			}
			if(isset($v['assign2'])){
				$d = std2arr($this->admin->getPersonnel($v['assign2']));
				if(count($d)) $v['assign2'] = $d[0]['person'];
				else $v['assign2'] = "";
			}
			
			if($v['tag']){
				$v['tag'] = array_tag($v['tag']);
			}
			
			if(isset($v['barangay']) && $v['barangay']){
				$brgy = $this->admin->getBarangay($v['barangay']);
				$v['barangay'] = $brgy[0]['name'];
			}else{
				$v['barangay'] = "";
			}
			
			$v['read'] = $this->checkTicketMsg($v['id']);
			
			array_push($array,$v);
		}
		$data['closed_tickets'] = $array;
		#pre($array);
		#$content['content'] = $this->load->view('cityaccess/ticketlist.php', $data, TRUE);
		$this->load->view('cityaccess/ticketlist.php', $data);
	}
	
	function viewTicket($id=""){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}
		if(!trim($id)){
			return false;
		}
		$data = array();
		$result = $this->citymodel->getTicketList('new');
		$data['new_tickets'] = $result;
		$data['ticket'] = $this->citymodel->getTicketDetails($id);
		$data['messages'] = $this->citymodel->ticketMessages($id);
		$data['categories'] = $this->citymodel->getCategories();
		$data['departments'] = $this->citymodel->getDepartments();
		$data['barangay'] = $this->admin->getBarangay();
		
		if($data['ticket'][0]['status']=='dispatched'){
			$data['category'] = $this->citymodel->getCategoryNameById($data['ticket'][0]['category']);
			$data['department'] = $this->citymodel->getDepartmentNameById($data['ticket'][0]['department']);
		}
		#$content['content'] = $this->load->view('cityaccess/ticketlist.php', $data, TRUE);
		$this->load->view('cityaccess/ticket.php', $data);
	}
	
	function parkTicket($id){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}
		if(isset($_POST['park_tag'])) $tag = $_POST['park_tag'];
		else $tag = "";
		$this->citymodel->parkTicket($id, $_POST['message'], $tag);
		//$this->sendSMS($_POST['action'],false);
		//refresh thread
		?>
		<script>
		viewThread("<?php echo $id; ?>");
		jQuery("#textarea_message_id").val("");
		</script>
		<?php		
	}
	
	function dispatchTicket($id){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}
		
		if($_POST['brgy']=='other'){
			$brgy = $this->admin->createBarangay($_POST['name'],$_POST['long'],$_POST['lat']);
		}else{
			$brgy = $_POST['brgy'];
		}
		$this->citymodel->dispatchTicket($id, $_POST['message'],$_POST['category_id'],$_POST['department_id'],$brgy);
		//$this->sendSMS($_POST['action'],false);
		//refresh thread
		?>
		<script>
		viewThread("<?php echo $id; ?>");
		jQuery("#textarea_message_id").val("");
		</script>
		<?php		
	}
	
	function internalMessage($id){ //ajax use
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}	
		$this->citymodel->internalMessage($id, $_POST['message']);
		//$this->sendSMS($_POST['action'],false);
		//refresh thread
		?>
		<script>
		viewThread("<?php echo $id; ?>");
		jQuery("#textarea_message_id").val("");
		</script>
		<?php
	}
	
	function sendReply($id){  //ajax use
		//get the mobile number 
		//$this->sms->sendSMS($number,$sms)
		//
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}
		
		$ticket = std2arr($this->citymodel->getTicketDetails($id));
		if(trim($ticket[0]['number'])){
			//$sms = "Kailangan namin ng karagdagang impormasyon para matugunan ang iyong report. ".$_POST['message']."? Para mag-reply, i-text ang TINGOG REP<report#>/<message>. Ex. TINGOG REP 12345/ Barangay health station P1/txt";
			$sms = $_POST['message'];
			$this->sms->sendSMS($ticket[0]['number'],$sms, 1);
		}
		if(trim($ticket[0]['email'])){
			$msg = "Kailangan namin ng karagdagang impormasyon para matugunan ang iyong report. ".$_POST['message']."?";
			$this->sms->sendEmail($ticket[0]['email'],$msg);
		}
		#pre($ticket);
		#exit();
		
		$this->citymodel->sendReply($id, $_POST['message']);
		//refresh thread
		?>
		<script>
		viewThread("<?php echo $id; ?>");
		jQuery("#textarea_message_id").val("");
		</script>
		<?php
	}
	
	function tagTicket($id){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}	
		
		$this->citymodel->tagTicket($id, $_POST['tag']);
		#$this->sendSMS($_POST['action'],false);
	}
	
	function sendSMSNotification($full=0){  //ajax use
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}
	}
	
	function viewThread($id=""){ //for ajax use
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}	
		if(!trim($id)){
			return false;
		}
		$ticket = $this->citymodel->getTicketDetails($id);
		$data['ticket'] = $ticket[0];
		$data['messages'] = $this->citymodel->ticketMessages($id);
		#pre($data);
		echo $this->load->view("cityaccess/thread", $data);	
			
	}
	
	function sendSMS($type=0,$no="639273779066"){
		if(checkPermission(get_class($this), __FUNCTION__)){
			if($type==1){ //Send Full Message SMS
				
			}
			elseif($type==2){ //Send SMS Notification
				
			}
			elseif($type==3){ //No SMS
				
			}
		}
		return true;
	}
	
	function directory(){
		$data = array();
		$data['personnels'] = std2arr($this->admin->getPersonnel(false));
		$data['users'] = std2arr($this->admin->adminUsers());
		
		$this->load->view('admin/directory.php', $data);
	}
	
	function masterList(){
		$data = array();
		$data['text'] = std2arr($this->admin->getMasterList());
		
		$this->load->view('admin/masterlist.php', $data);
	}
	
	function masterListSubmit(){
		$text = $this->citymodel->updateMasterList($_REQUEST['text']);
		echo nl2br($text);
	}
	
	function summary(){
		$array = array();
		$range = array('from'=>0,'to'=>0);
		$result = $this->report->filterTickets($array,$range);
		$status = array('new','dispatched','returned','assigned','resolved','parked','closed');
		$tickets = array();
		$response = array();
		$closed = array();
		$parked = array();
		foreach($result as $k=>$v){
			if(!isset($tickets[$v['status']])) $tickets[$v['status']] = 1;
			else $tickets[$v['status']]++;
			
			if($v['status']=="closed"){
				if(!isset($closed[$v['tag']])) $closed[$v['tag']] = 1;
				else $closed[$v['tag']]++;
			}
			
			if($v['status']=="parked"){
				if(!isset($parked[$v['tag_park']])) $parked[$v['tag_park']] = 1;
				else $parked[$v['tag_park']]++;
			}
			
			
			if($v['status']=="resolved"){
				if(strtotime($v['date']) && strtotime($v['resolve_date'])){
					$diff = round((strtotime($v['resolve_date']) - strtotime($v['date'])) / 60 / 60 / 24, 2);
					$response[] = $diff;
				}
			}
		}
		
		if(count($response)){
			$data['average_response'] = (round(array_sum($response) / count($response)));
		}
		
		foreach($status as $k=>$v){
			if(isset($tickets[$v])){
				$data['status'][$v] = $tickets[$v];
			}else{
				$data['status'][$v] = 0;
			}
		}
		$data['closed'] = $closed;
		$data['parked'] = $parked;
		
		$opt['departments'] = std2arr($this->admin->getDepartments());
		$opt['categories'] = std2arr($this->admin->getCategory());
		$opt['issues'] = std2arr($this->admin->getIssues());
		#$data['locations'] = $this->report->getLocation();
		$opt['locations'] = $this->admin->getBarangay();
		$opt['filter_ajax'] = '/backend/cityaccess/filter';
		$opt['report_container_id'] = 'report_container';
		
		$this->load->view('report/filter', $opt);
		//$this->load->view('report/piechart', $data);
	}
	
	public function filter(){
		$data = array();
		$ticket_list = array();
		$data['departments'] = std2arr($this->admin->getDepartments());
		$data['categories'] = std2arr($this->admin->getCategory());
		$data['issues'] = std2arr($this->admin->getIssues());
		#$data['locations'] = $this->report->getLocation();
		$data['locations'] = $this->admin->getBarangay();
		$data['page_title'] = 'Ticket Report';
		$closed = array();
		$parked = array();
		$array = array(
			'department'=> isset($_POST['department']) ? $_POST['department'] : "",
			'category'=> isset($_POST['category']) ? $_POST['category'] : "",
			'issue'=> isset($_POST['issue']) ? $_POST['issue'] : "",
			'barangay'=> isset($_POST['location']) ? $_POST['location'] : ""
		);
		$range = array(
			'from'=> isset($_POST['datepicker_from']) ? $_POST['datepicker_from'] : 0,
			'to'=> isset($_POST['datepicker_to']) ? $_POST['datepicker_to'] : 0
		);
		
		$result = $this->report->filterTickets($array,$range);
		#pre($this->db->last_query());
		$status = array('new','dispatched','returned','assigned','resolved','parked','closed');
		$tickets = array();
		$response = array();
		foreach($result as $k=>$v){
			#pre($v);
			if(!isset($tickets[$v['status']])) $tickets[$v['status']] = 1;
			else $tickets[$v['status']]++;
			
			#if($v['status']=="parked"){
			#	if(isset($parked[$v[]]))
			#}
			if($v['status']=="closed"){
				if(!isset($closed[$v['tag']])) $closed[$v['tag']] = 1;
				else $closed[$v['tag']]++;
			}
			
			if($v['status']=="parked"){
				if(!isset($parked[$v['tag_park']])) $parked[$v['tag_park']] = 1;
				else $parked[$v['tag_park']]++;
			}
			
			
			if($v['status']=="resolved"){
				if(strtotime($v['date']) && strtotime($v['resolve_date'])){
					#pre(strtotime($v['resolve_date']));
					#pre($v['id']);
					$diff = round((strtotime($v['resolve_date']) - strtotime($v['date'])) / 60 / 60 / 24, 2);
					$response[] = $diff;
				}
			}
			
			if(isset($v['department'])){
				$d = std2arr($this->admin->getDepartments($v['department']));
				$v['department'] = $d[0]['department'];
			}
			
			if(isset($v['barangay']) && $v['barangay']){
				$brgy = $this->admin->getBarangay($v['barangay']);
				$v['barangay'] = $brgy[0]['name'];
			}else{
				$v['barangay'] = "";
			}
			
			if(isset($v['issue']) && $v['issue']){
				$x = std2arr($this->admin->getIssues($v['issue']));
				$v['issue'] = $x[0]['issue'];
			}else{
				$v['issue'] = "";
			}
			
			if(isset($v['category']) && $v['category']){
				$x = std2arr($this->admin->getCategory($v['category']));
				$v['category'] = $x[0]['category'];
			}else{
				$v['category'] = "";
			}
			
			if(isset($v['assign1']) && $v['assign1']){
				$d = std2arr($this->admin->getPersonnel($v['assign1']));
				if(count($d)) $v['assign1'] = $d[0]['person'];
				else $v['assign1'] = "";
			}
			if(isset($v['assign2']) && $v['assign2']){
				$d = std2arr($this->admin->getPersonnel($v['assign2']));
				if(count($d)) $v['assign2'] = $d[0]['person'];
				else $v['assign2'] = "";
			}
			
			array_push($ticket_list,$v);
		}
		
		#$_SESSION['ticket_list'] = serialize($ticket_list);
		
		if(count($response)){
			$data['average_response'] = (round(array_sum($response) / count($response)));
		}
		
		foreach($status as $k=>$v){
			#pre($v);
			if(isset($tickets[$v])){
				$data['status'][$v] = $tickets[$v];
			}else{
				$data['status'][$v] = 0;
			}
		}
		$data['closed'] = $closed;
		$data['parked'] = $parked;
		$data['ticket_list'] = $ticket_list;
		$data['report_container_id'] = 'report_container';
		$this->load->view('report/piechart', $data);
	}
	
	function myAccount(){
		$data = array();
		$data['user_data'] = $this->admin->getAdminUser($_SESSION['user_id']);
		$this->load->view('cityaccess/myaccount.php', $data);
	}
	
	function myAccountSubmit($id){
			$array = array(
				'fname'=>$_POST['fname'],
				'mname'=>$_POST['mname'],
				'lname'=>$_POST['lname'],
				'address'=>$_POST['address'],
				'mobile'=>$_POST['mobile'],
				'email'=>$_POST['email']
			);
			if(isset($_POST['user_password1'])&& strlen($_POST['user_password1'])){
				if($_POST['user_password1']==$_POST['user_password2']){
					$array['user_password'] = md5($_POST['user_password1']);
				}else{
					echo "<a style='color:red'>New Password not matched.</a>";
					exit();
				}
			}
			
			$result = $this->admin->editAdminUser($id,$array);
			if($result){
				// run a javascript here
				echo "<script>";
				#echo "jQuery('#editform')[0].reset();";
				echo "alert('User Account successfully updated!');";
				echo "</script>";
			}
	}
	
	public function reOpenTicket($id){
		if($id){
			$this->citymodel->reOpenTicket($id);
		}
		return true;
	}

}
?>