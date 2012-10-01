<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Citizen extends CI_Controller {
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
		$data['page_title'] = 'Citizen Partner\'s Dashboard &raquo; Reports';
		if(checkPermission(get_class($this), __FUNCTION__)){
			$result = $this->citymodel->getTicketList('new');
			$data['total_new'] = count($result);
			$content = array();
			$content['content'] = $this->load->view('citizen/dashboard', $data, TRUE);
			$this->load->view('layout/main', $content);
			#pre($data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
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
			
			$v['read'] = $this->citymodel->ticketMessages($v['id']);
			
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
		
		$result = $this->checkTicketMsg('closed');
		$array = array();
		$i=0;
		if(is_array($result)){
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
		}
		$data['closed_tickets'] = $array;
		
		$result = $this->citymodel->getTicketList('resolved');
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
		#pre($array);
		#$content['content'] = $this->load->view('cityaccess/ticketlist.php', $data, TRUE);
		$this->load->view('citizen/ticketlist.php', $data);
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
	
	function viewTicket($id){
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
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
		$this->load->view('citizen/ticket.php', $data);
	}
	
	function viewThread($id){ //for ajax use
		if(!checkPermission(get_class($this), __FUNCTION__)){
			$content['content'] = returnNoAccessRight();
			$this->load->view('layout/main', $content);
			exit();
		}	
		$ticket = $this->citymodel->getTicketDetails($id);
		$data['ticket'] = $ticket[0];
		$data['messages'] = $this->citymodel->ticketMessages($id);
		#pre($data);
		echo $this->load->view("cityaccess/thread", $data);	
			
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