<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller {
	var $report;
	public function __construct(){
		//load initial models and libraries that are needed for the controller
		parent::__construct();
		$this->load->database();
		$this->load->model("admin_model");
		$this->admin = new Admin_Model();
		
		$this->load->model("report_model");
		$this->report = new Report_Model();
		
		$this->load->helper("functions_helper");
	}
	
	public function index(){
		$data = array();
		$data['page_title'] = 'Dashboard';
		$content = array();
		$content['content'] = $this->load->view('report/dashboard', $data, TRUE);
		$this->load->view('layout/main', $content);
	}
	
	public function basic(){
		$data = array();
		$data['departments'] = std2arr($this->admin->getDepartments());
		$data['categories'] = std2arr($this->admin->getCategory());
		$data['issues'] = std2arr($this->admin->getIssues());
		$data['locations'] = $this->report->getLocation();
		$data['filter_ajax'] = '/backend/report/filter';
		$data['report_container_id'] = 'ticket_list';
		$this->load->view('report/filter', $data);
	}
	
	public function filter(){
		$data = array();
		$ticket_list = array();
		$data['departments'] = std2arr($this->admin->getDepartments());
		$data['categories'] = std2arr($this->admin->getCategory());
		$data['issues'] = std2arr($this->admin->getIssues());
		#$data['locations'] = $this->report->getLocation();
		$data['locations'] = $this->admin->getBarangay();
		$data['page_title'] = 'Report';
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
		
		$_SESSION['ticket_list'] = serialize($ticket_list);
		
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
		#pre($data['status']);
		
		$data['ticket_list'] = $ticket_list;
		#$content['content'] = $this->load->view('report/filter', $data, TRUE);
		$this->load->view('report/ticket_list', $data);
		#$this->load->view('layout/main', $content);
	}

	public function ticketWs(){
		$data = array();
		$data['departments'] = std2arr($this->admin->getDepartments());
		$data['categories'] = std2arr($this->admin->getCategory());
		$data['issues'] = std2arr($this->admin->getIssues());
		#$data['locations'] = $this->report->getLocation();
		$data['locations'] = $this->admin->getBarangay();
		$data['page_title'] = 'Report';
		
		$categories = array();
		$issues = array();
		$departments = array();
		$barangays = array();
		
		$closed = array();
		$parked = array();
		$array = array(
			'department'=> isset($_POST['department']) ? $_POST['department'] : "",
			'category'=> isset($_POST['category']) ? $_POST['category'] : "",
			'issue'=> isset($_POST['issue']) ? $_POST['issue'] : "",
			'barangay'=> isset($_POST['location']) ? $_POST['location'] : ""
		);
		#$range = array();
		#if(isset($_POST['datepicker_from']) && isset($_POST['datepicker_to'])){
		$range = array(
			'from'=> isset($_POST['datepicker_from']) ? $_POST['datepicker_from']:0,
			'to'=> isset($_POST['datepicker_to']) ? $_POST['datepicker_to'] : 0
		);
		#}
		
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
			
			if($v['category']){
				if(isset($categories[$v['category']])) $categories[$v['category']]++;
				else $categories[$v['category']]=1;
			}
			
			if($v['issue']){
				if(isset($issues[$v['issue']])) $issues[$v['issue']]++;
				else $issues[$v['issue']]=1;
			}
			#pre($issues);
			
			if($v['department']){
				if(isset($departments[$v['department']])) $departments[$v['department']]++;
				else $departments[$v['department']]=1;
			}
			
			if($v['status']=='parked'){
				#if(isset($issues[$v['issue']])) $issues[$v['issue']]++;
				#else $issues[$v['issue']]=1;
			}
			
			if($v['barangay']){
				if(isset($barangays[$v['barangay']]['count'])) $barangays[$v['barangay']]['count']++;
				else $barangays[$v['barangay']]['count']=1;
				
				
				if($v['status']=='resolved'){
					if(isset($barangays[$v['barangay']]['resolved'])) $barangays[$v['barangay']]['resolved']++;
					else $barangays[$v['barangay']]['resolved'] = 1;
				}
				
				
				if(($v['status']=='new') || ($v['status']=='dispatched') || ($v['status']=='assigned')){
					#pre('Unres: '.$v['status']);
					if(isset($barangays[$v['barangay']]['unresolve'])) $barangays[$v['barangay']]['unresolve']++;
					else $barangays[$v['barangay']]['unresolve'] = 1;
					
					if($v['status']=='dispatched'){
						if(isset($barangays[$v['barangay']]['dispatched'])) $barangays[$v['barangay']]['dispatched']++;
						else $barangays[$v['barangay']]['dispatched'] = 1;
					}
					
					if($v['status']=='assigned'){
						if(isset($barangays[$v['barangay']]['assigned'])) $barangays[$v['barangay']]['assigned']++;
						else $barangays[$v['barangay']]['assigned'] = 1;
					}
					
				}else{
					#pre('Res: '.$v['status']);
				}
			}

			if($v['department']){
				if(isset($office[$v['department']]['count'])) $office[$v['department']]['count']++;
				else $office[$v['department']]['count']=1;
				
				
				if($v['status']=='resolved'){
					if(isset($office[$v['department']]['resolved'])) $office[$v['department']]['resolved']++;
					else $office[$v['department']]['resolved'] = 1;
				}
				
				
				if(($v['status']=='new') || ($v['status']=='dispatched') || ($v['status']=='assigned')){
					#pre('Unres: '.$v['status']);
					if(isset($office[$v['department']]['unresolve'])) $office[$v['department']]['unresolve']++;
					else $office[$v['department']]['unresolve'] = 1;
					
					if($v['status']=='dispatched'){
						if(isset($office[$v['department']]['dispatched'])) $office[$v['department']]['dispatched']++;
						else $office[$v['department']]['dispatched'] = 1;
					}
					
					if($v['status']=='assigned'){
						if(isset($office[$v['department']]['assigned'])) $office[$v['department']]['assigned']++;
						else $office[$v['department']]['assigned'] = 1;
					}
					
				}else{
					#pre('Res: '.$v['status']);
				}
			}
			
		}
		#pre(count($result));
		
		if(count($response)){
			$data['average_response'] = (round(array_sum($response) / count($response)));
		}
		#pre($closed);
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
		$data['chart'] = array(
			'categories'=>$categories,
			'issues'=>$issues,
			'parks'=>$parked,
			'department'=>$departments,
			'barangays'=>$barangays,
			'office'=>$office
		);
		#pre($data['chart']);
		
		#$content['content'] = $this->load->view('report/filter', $data, TRUE);
		#$content['content'] .= $this->load->view('report/piechart', $data, TRUE);
		$content['data'] = json_encode(array($data));
		$this->load->view('ticket/json', $content);
		#pre($data);
	}
	
	function exportCSV(){
		$result = unserialize($_SESSION['ticket_list']);
		#unset($_SESSION['ticket_list']);
		if(count($result)){
			$filename = 'ticket_export_'.date("Y-m-d_H-i",time());
			header( 'Content-Type: text/csv' );
			header( 'Content-Disposition: attachment;filename='.$filename.".csv");
            $fp = fopen('php://output', 'w');
			//Report #, Date, Message, Category, Issue, Office, Assigned, Status, Last updated (of the status)
			$column = array(
				"Report Number",
				"Date",
				"Message",
				"Category",
				"Issue",
				"Office",
				"Assigned",
				"Status",
				"Last Updated"
			);
			fputcsv($fp, $column);
			foreach($result as $k=>$r){
				if($r['tag_park']) $r['tag_park'] = array_parked($r['tag_park']);
				if($r['tag']) $r['tag'] = array_tag($r['tag']);
				if($r['assign1']=="0") $r['assign1'] = "";
				if($r['assign2']=="0") $r['assign2'] = "";
				
				$row = array(
					zeroes($r['id'], 6),
					date("M d, Y H:i",strtotime($r['date'])),
					$r['description'],
					$r['category'],
					$r['issue'],
					$r['department'],
					$r['assign1']." ".$r['assign2'],
					$r['status'],
					date("M d, Y H:i",strtotime($r['last_update']))
				);
				fputcsv($fp, $row);
				#pre($r);
			}
			fclose($fp);
			#
		}else{
			echo "No records to export.";
		}
	}
}
?>