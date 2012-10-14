<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department extends CI_Controller {
	var $admin;
	var $departmentmodel;
	var $report;
	public function __construct(){
		//load initial models and libraries that are needed for the controller
		parent::__construct();
		$this->load->database();
		$this->load->model("department_model");
		$this->departmentmodel = new Department_Model();
		
		$this->load->model("report_model");
		$this->report = new Report_Model();
		
		$this->load->model("admin_model");
		$this->admin = new Admin_Model();
		
		$this->load->model("sms_model");
		$this->sms = new SMS_Model();
		
		$this->load->helper("functions_helper");
	}
	
	public function index(){
		$data = array();
		$data['page_title'] = 'Concerned Office\'s Dashboard &raquo; Reports';
		if(checkPermission(get_class($this), __FUNCTION__)){
			$result = $this->departmentmodel->getTicketList('dispatched');
			$data['total_new'] = count($result);
			
			$content = array();
			$content['content'] = $this->load->view('department/dashboard', $data, TRUE);
			$this->load->view('layout/main', $content);
			#pre($data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function checkTicketMsg($id){
		$result = $this->departmentmodel->ticketMessages($id);
		foreach($result as $k=>$r){
			if($r['read']==0){
				$unread = true;
			}
		}
		
		if(isset($unread)) return true;
		else return false;
	}
	
	
	function depListTicket(){
		$data = array();
		#$result = $this->departmentmodel->getTicketList('new');
		#$data['new_tickets'] = $result;
		
		$result = $this->departmentmodel->getTicketList('dispatched');
		#$data['dispatched_tickets'] = $result;
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
		$data['dispatched_tickets'] = $array;
		
		$result = $this->departmentmodel->getTicketList('assigned');
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
			
			if(isset($v['barangay']) && $v['barangay']){
				$brgy = $this->admin->getBarangay($v['barangay']);
				$v['barangay'] = $brgy[0]['name'];
			}else{
				$v['barangay'] = "";
			}
			
			$v['read'] = $this->checkTicketMsg($v['id']);
			
			array_push($array,$v);
		}
		$data['assigned_tickets'] = $array;
		
		$result = $this->departmentmodel->getTicketList('resolved');
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
		
		
		$data['responded_tickets'] = $array;
		
		$result = $this->departmentmodel->getTicketList('parked');
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
		$data['parked_tickets'] = $array;
		
		#$content['content'] = $this->load->view('cityaccess/ticketlist.php', $data, TRUE);
		$this->load->view('department/ticketlist.php', $data);
	}
	
	function depviewticket($id=""){
		#pre(get_class($this).'->'.__FUNCTION__);
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}	
		
		if(!trim($id)){
			return false;
		}
		
		$data = array();
		$data['ticket'] = $this->departmentmodel->getTicketDetails($id);
		$data['categories'] = $this->departmentmodel->getCategories();
		$data['departments'] = $this->departmentmodel->getDepartments();
		
		$data['personnels'] = $this->departmentmodel->getPersonnels();
		$data['issues'] = $this->departmentmodel->getIssues();
		$data['issue'] = $this->departmentmodel->getIssuesById($data['ticket'][0]['issue']);
		$data['personnelcomplete1'] = $this->departmentmodel->getPersonnelByIdComplete($data['ticket'][0]['assign1']);
		$data['personnelcomplete2'] = $this->departmentmodel->getPersonnelByIdComplete($data['ticket'][0]['assign2']);
		
		if(isset($data['ticket'][0]['barangay']) && $data['ticket'][0]['barangay']){
			$brgy = $this->admin->getBarangay($data['ticket'][0]['barangay']);
			$data['ticket'][0]['barangay'] = $brgy[0]['name'];
		}else{
			$data['ticket'][0]['barangay'] = "";
		}
		//$this->departmentmodel->markedTicketasRead($id);
		$this->load->view('department/ticket.php', $data);
	}
	
	function assign($id){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}
		#pre("hello");
		#exit();
		$message = $_POST['message'];
		
		/*
		$sms = $_POST['sms'];
		$ticket_id = $id;
		$ticket = std2arr($this->departmentmodel->getTicketDetails($id));
		$message_head = "";
		if(is_array($sms)){
			$numbers = array();
			foreach($sms as $number){
				//send sms
				if(trim($number)&&!in_array($number, $numbers)){
					$numbers[] = $number;
				}
			}
			if(count($numbers)){
				$message_head = "Sent SMS to ".implode(", ", $numbers)."\n\n";
				foreach($numbers as $number){
					$this->sms->sendSMS($number,$message, 3);
				}
			}
		}
		*/
		$this->departmentmodel->assignTicket($id, $_POST['message'],$_POST['issue_id'],$_POST['personnel_id'],$_POST['personnel_id2'],$_POST['datepicker']);
		?>
		<script>
		viewThread("<?php echo $id; ?>");
		jQuery("#textarea_message_id").val("");
		</script>
		<?
	}
	
	function parkTicket($id){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}
		$ticket = std2arr($this->departmentmodel->getTicketDetails($id));
		
		if(isset($_POST['park_tag'])){
			$tag = $_POST['park_tag'];
			if(trim($ticket[0]['number'])){
				if($tag=="PF"){
					$sms = $_POST['message'];
					$this->sms->sendSMS($ticket[0]['number'],$sms, "0");
				}
				else if($tag=="NFA"){
					$sms = $_POST['message'];
					$this->sms->sendSMS($ticket[0]['number'],$sms, "0");
				}
			}
		}
		else{
			$tag = "";
		}
		$this->departmentmodel->parkTicket($id, $_POST['message'], $tag);
		//refresh thread
		?>
		<script>
		viewThread("<?php echo $id; ?>");
		jQuery("#textarea_message_id").val("");
		</script>
		<?php		
	}
	
	function returnTicket($id){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}	
		$this->departmentmodel->returnTicket($id, $_POST['message']);
		//refresh thread
		?>
		<script>
		viewThread("<?php echo $id; ?>");
		jQuery("#textarea_message_id").val("");
		</script>
		<?php		
	}
	
	function resolveTicket($id){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}
		
		if(isset($_POST['message'])) $msg = $_POST['message'];
		else $msg = "";
		
		$ticket_id = $id;
		$ticket = std2arr($this->departmentmodel->getTicketDetails($id));
		if(trim($ticket[0]['number'])){
			/*$sms = "Magandang araw! May kaukulang aksyon na ang iyong report ".$ticket_id.". ".$msg.". 

Anong masasabi mo sa aming serbisyo? Para sumagot, i-text ang TINGOG REP<report#>/<message>. Ex. TINGOG REP 12345/salamat! P1/txt";
			*/
			$sms = $_POST['message'];
			$this->sms->sendSMS($ticket[0]['number'],$sms, "0");
		}
		
		$this->departmentmodel->resolveTicket($id, $msg);
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
		$message = $_POST['message'];
		$sms = $_POST['sms'];
		$ticket_id = $id;
		$ticket = std2arr($this->departmentmodel->getTicketDetails($id));
		$message_head = "";
		if(is_array($sms)){
			$numbers = array();
			foreach($sms as $number){
				//send sms
				if(trim($number)&&!in_array($number, $numbers)){
					$numbers[] = $number;
				}
			}
			if(count($numbers)){
				$message_head = "Sent SMS to ".implode(", ", $numbers)."\n\n";
				foreach($numbers as $number){
					$this->sms->sendSMS($number,$message, 1);
				}
			}
		}
		$message_foot = "";
		if($ticket_id){
			$message_foot = "";
		}
		
		$this->departmentmodel->internalMessage($id, $message_head.$message.$message_foot);
		//refresh thread
		?>
		<script>
		viewThread("<?php echo $id; ?>");
		jQuery("#textarea_message_id").val("");
		</script>
		<?php
	}
	
	function sendReply($id){  //ajax use
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}	
		$sms = $_POST['message'];
		
		
		$ticket = std2arr($this->departmentmodel->getTicketDetails($id));
		if(trim($ticket[0]['number'])){
			//$sms = "Kailangan namin ng karagdagang impormasyon para matugunan ang iyong report. ".$_POST['message']."? Para mag-reply, i-text ang TINGOG REP<report#>/<message>. Ex. TINGOG REP 12345/ Barangay health station P1/txt";
			$sms = $_POST['message'];
			$this->sms->sendSMS($ticket[0]['number'],$sms, "1");
		}
		if(trim($ticket[0]['email'])){
			$msg = "Kailangan namin ng karagdagang impormasyon para matugunan ang iyong report. ".$_POST['message']."?";
			$this->sms->sendEmail($ticket[0]['email'],$msg);
		}
		
		$this->departmentmodel->sendReply($id, $_POST['message']);
		
		//refresh thread
		?>
		<script>
		viewThread("<?php echo $id; ?>");
		jQuery("#textarea_message_id").val("");
		</script>
		<?php
	}
	
	function viewThread($id=""){ //for ajax use
		if(!checkPermission(get_class($this), __FUNCTION__)){
			pre('Not allowed');
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}	
		
		if(!trim($id)){
			return false;
		}
		$ticket = $this->departmentmodel->getTicketDetails($id);
		$data['ticket'] = $ticket[0];
		$data['messages'] = $this->departmentmodel->ticketMessages($id);
		#pre($data);
		echo $this->load->view("department/thread", $data);	
			
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
		
		#$content['content'] = $this->load->view('report/piechart', $data, TRUE);
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
}
?>