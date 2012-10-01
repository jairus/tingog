<?php
@session_start();
class Ticket_Model extends CI_Model{
	function Ticket_Model(){
		parent::__construct();
		$this->load->database();
	}
	
	function getTickets($array=array()){
		if(count($array)){
			foreach($array as $k=>$v){
				$this->db->where($k,$v);
				#pre($k.'->'.$v);
			}
			$result = $this->db->get('tickets');
		}else{
			$result = $this->db->get('tickets');
		}
		#pre($result);
		#pre($result->num_rows());
		return $result->result_array();
	}
	
	function getTicketByNumId($id=NULL,$num=NULL){
		$this->db->where(array('id'=>$id,'number'=>$num));
		$result = $this->db->get('tickets');
		return $result->result_array();
	}
}
?>