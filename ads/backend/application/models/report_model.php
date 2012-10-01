<?php
class Report_Model extends CI_Model{
	function Admin_Model(){
		parent::__construct();
		$this->load->database();
	}
	
	function getLocation(){
		$array = array();
		#$this->db->distinct('location');
		$result = $this->db->query("SELECT DISTINCT location FROM tickets");
		$r = std2arr($result->result_array());
		foreach($r as $k=>$v){
			if(trim($v['location'])){
				array_push($array,$v['location']);
			}
		}
		return $array;
	}
	
	function filterTickets($array,$range){
		foreach($array as $k=>$v){
			if(trim($v)) $this->db->where($k,mysql_escape_string($v));
		}
		
		if(strtotime($range['from'])) $this->db->where('date >=',mysql_escape_string(date("Y-m-d 00:00:01",strtotime($range['from']))));
		if(strtotime($range['to'])) $this->db->where('date <=',mysql_escape_string(date("Y-m-d 23:59:59",strtotime($range['to']))));
		
		$result = $this->db->get('tickets');
		return std2arr($result->result_array());
	}
}
?>