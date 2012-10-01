<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ticket extends CI_Controller {
	var $admin;
	var $ticket;
	public function __construct(){
		//load initial models and libraries that are needed for the controller
		parent::__construct();
		$this->load->database();
		
		$this->load->model("admin_model");
		$this->admin = new Admin_Model();
		
		$this->load->model("ticket_model");
		$this->ticket = new Ticket_Model();
		
		$this->load->helper("functions_helper");
	}
	
	public function index(){
		
	}
	
	public function barangay(){
		$content = array();
		$data = $this->admin->getBarangay();
		$out = array();
		$i = 0;
		foreach($data as $k=>$v){
			$res = $this->ticket->getTickets(array('barangay'=>$v['id']));
			$out[$i] = array('id'=>$v['id'],'name'=>$v['name'],'long'=>$v['long'],'lat'=>$v['lat'],'total'=>count($res));
			$i++;
		}
		
		$content['data'] = json_encode($out);
		$this->load->view('ticket/json', $content);
	}
	
	public function getReport(){
		$content = array();
		$data = $this->ticket->getTicketByNumId($_POST['report_num'],$_POST['mobile_num']);
		#pre($data);
		if(isset($data[0]['status'])){
			echo 'Current Report Status: '.ucwords($data[0]['status']);
		}else{
			echo 'Invalid Report';
		}
	}
}
?>