<?php
class Department_Model extends CI_Model{
	function Cityaccess_Model(){
		parent::__construct();
		$this->load->database();
	}
	
	function getTicketList($status=NULL){
		if($status) $this->db->where('status',$status);
		$this->db->order_by('id','desc');
		if($_SESSION['access_level']!='admin'){
			$this->db->where('department',$_SESSION['department']);
		}
		$result = $this->db->get('tickets');
		$r = $result->result_array();
		return $r;
	}
	
	function getTicketDetails($id){
		$this->db->where('id',$id);
		$result = $this->db->get('tickets');
		$r = $result->result_array();
		
		#$this->db->set('read',1);
		#$this->db->where('tid',$id);
		#$this->db->update('tickets_msg');
		
		return $r;
	}
	
	function getCategories(){
		$sql = "select * from `categories` where `deleted`=0";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getDepartments(){
		$sql = "select * from `departments` where `deleted`=0";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getIssues(){
		$sql = "select * from `issues` where `deleted`=0";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getIssuesById($id){
		$this->db->where("id",$id);
		$query = $this->db->get('issues');
		if($query->num_rows()>0){
			$r = $query->result_array();
			return $r[0]['issue'];
		}else{
			return "";
		}
	}
	
	function getPersonnels(){
		$sql = "select * from `personnel`";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getPersonnelById($id){
		$this->db->where("id",$id);
		$query = $this->db->get('personnel');
		if($query->num_rows() > 0){
			$r = $query->result_array();
			return $r[0]['person'];
		}else{
			return "";
		}
	}
	
	function assignTicket($id, $message, $issue, $personnel, $personnel2, $duedate){
		if(!$id){
			return false;
		}
		$id = mysql_escape_string($id);
		$message = mysql_escape_string($message);
		$sql = "insert into `tickets_msg` set 
			`type`='Assign Message',
			`msg` = '".$message."',
			`tid` = '".$id."',
			`user` = '".$_SESSION['user_id']."',
			`date` = NOW()
			";
		$query = $this->db->query($sql);
		
		$sql = "update `tickets` set 
			`status`='assigned',
			`issue`='".$issue."',
			`assign1`='".$personnel."',
			`assign2`='".$personnel2."',
			`duedate`='".date("Y-m-d",strtotime($duedate))."',
			`last_update` = NOW()
			where `id` = '".$id."'
			";
		$query = $this->db->query($sql);
	}
	
	function parkTicket($id, $message, $tag=NULL){
		if(!$id){
			return false;
		}
		$array_parked = array_parked();
		$id = mysql_escape_string($id);
		$message = mysql_escape_string($message);
		$sql = "insert into `tickets_msg` set 
			`type`='Parked - ".$array_parked[$tag]."',
			`msg` = '".$message."',
			`tid` = '".$id."',
			`user` = '".$_SESSION['user_id']."',
			`date` = NOW()
			";
		$query = $this->db->query($sql);
		
		$sql = "update `tickets` set 
			`status`='parked',
			`last_update` = NOW()
			where `id` = '".$id."'
			";
		$query = $this->db->query($sql);
	}
	
	function returnTicket($id, $message){
		if(!$id){
			return false;
		}
		$id = mysql_escape_string($id);
		$message = mysql_escape_string($message);
		$sql = "insert into `tickets_msg` set 
			`type`='Return to Dispatcher',
			`msg` = '".$message."',
			`tid` = '".$id."',
			`user` = '".$_SESSION['user_id']."',
			`date` = NOW()
			";
		$query = $this->db->query($sql);
		
		$sql = "update `tickets` set 
			`status`='returned',
			`last_update` = NOW()
			where `id` = '".$id."'
			";
		$query = $this->db->query($sql);
	}
	
	function resolveTicket($id, $message){
		if(!$id){
			return false;
		}
		$id = mysql_escape_string($id);
		$message = mysql_escape_string($message);
		$sql = "insert into `tickets_msg` set 
			`type`='Resolve',
			`msg` = '".$message."',
			`tid` = '".$id."',
			`user` = '".$_SESSION['user_id']."',
			`date` = NOW()
			";
		$query = $this->db->query($sql);
		
		$sql = "update `tickets` set 
			`status`='resolved',
			`last_update` = NOW(),
			`resolve_date` = NOW()
			where `id` = '".$id."'
			";
		$query = $this->db->query($sql);
		#pre($this->db->last_query());
		#exit();
		#return $sql;
	}
	
	function internalMessage($id, $message){
		if(!$id){
			return false;
		}
		$id = mysql_escape_string($id);
		$message = mysql_escape_string($message);
		$sql = "insert into `tickets_msg` set 
			`type`='Internal Message',
			`msg` = '".$message."',
			`tid` = '".$id."',
			`user` = '".$_SESSION['user_id']."',
			`date` = NOW()
			";
		$query = $this->db->query($sql);
	}
	
	function sendReply($id, $message){
		if(!$id){
			return false;
		}
		$id = mysql_escape_string($id);
		$message = mysql_escape_string($message);
		$sql = "insert into `tickets_msg` set 
			`type`='Reply Message',
			`msg` = '".$message."',
			`tid` = '".$id."',
			`user` = '".$_SESSION['user_id']."',
			`date` = NOW()
			";
		$query = $this->db->query($sql);
	}
	
	function ticketMessages($tid){
		#$this->db->where('tid',$tid);
		#$this->db->order_by("date", "asc");
		#$query = $this->db->get('tickets_msg');
		$array = array();
		
		$sql = "select a.*, b.user_login from `tickets_msg` as `a` left join `users` as `b` on (`a`.`user`=`b`.`id`) where `tid`='".mysql_escape_string($tid)."' order by `date` asc";
		$query = $this->db->query($sql);
		foreach ($query->result() as $std){
			#pre(std2arr($row));
			$row = std2arr($std);
			#$row = $r[0];
			#pre($row);
			if($row['type']=='Internal Message'){
				array_push($array,array('user_login'=>$row['user_login'], 'user'=>$row['user'],'date'=>$row['date'],'msg'=>$row['msg'],'label'=>'Internal Message','div_class'=>'internal_message','read'=>$row['read'],'type'=>$row['type']));
			}
			else if($row['type']=='Assign Message'){
				array_push($array,array('user_login'=>$row['user_login'], 'user'=>$row['user'],'date'=>$row['date'],'msg'=>$row['msg'],'label'=>'Assign Message','div_class'=>'assign_message','read'=>$row['read'],'type'=>$row['type']));
			}
			#else if($row['type']=='Park Message'){
			else if(strstr($row['type'], 'Parked - ')){
				array_push($array,array('user_login'=>$row['user_login'], 'user'=>$row['user'],'date'=>$row['date'],'msg'=>$row['msg'],'label'=>'Park Message','div_class'=>'park_message','read'=>$row['read'],'type'=>$row['type']));
			}
			#else if($row['type']=='Dispatch Message'){
			else if(strstr($row['type'], 'Dispatch to ')){
				array_push($array,array('user_login'=>$row['user_login'], 'user'=>$row['user'],'date'=>$row['date'],'msg'=>$row['msg'],'label'=>'Dispatch to ','div_class'=>'dispatch_message','read'=>$row['read'],'type'=>$row['type']));
			}
			else if($row['type']=='Reply Message'){
				array_push($array,array('user_login'=>$row['user_login'], 'user'=>$row['user'],'date'=>$row['date'],'msg'=>$row['msg'],'label'=>'Reply Message','div_class'=>'reply_message','read'=>$row['read'],'type'=>$row['type']));
			}
			else if($row['type']=='SMS Reply'){
				array_push($array,array('user_login'=>$row['user_login'], 'user'=>$row['user'],'date'=>$row['date'],'msg'=>$row['msg'],'label'=>'SMS Reply','div_class'=>'sms_reply','read'=>$row['read'],'type'=>$row['type']));
			}
			else if($row['type']=='SMS Action'){
				array_push($array,array('user_login'=>$row['user_login'], 'user'=>$row['user'],'date'=>$row['date'],'msg'=>$row['msg'],'label'=>'SMS Action','div_class'=>'sms_reply','read'=>$row['read'],'type'=>$row['type']));
			}
			else if($row['type']=='E-mail Reply'){
				array_push($array,array('user_login'=>$row['user_login'], 'user'=>$row['user'],'date'=>$row['date'],'msg'=>$row['msg'],'label'=>'E-mail Reply','div_class'=>'email_reply','read'=>$row['read'],'type'=>$row['type']));
			}
			else if($row['type']=='Return to Dispatcher'){
				array_push($array,array('user_login'=>$row['user_login'], 'user'=>$row['user'],'date'=>$row['date'],'msg'=>$row['msg'],'label'=>'Return to Dispatcher','div_class'=>'return_to_dispatcher','read'=>$row['read'],'type'=>$row['type']));
			}
			else if($row['type']=='Resolve'){
				array_push($array,array('user_login'=>$row['user_login'], 'user'=>$row['user'],'date'=>$row['date'],'msg'=>$row['msg'],'label'=>'Resolve','div_class'=>'resolve_message','read'=>$row['read'],'type'=>$row['type']));
			}
		}
		#pre($array);
		return $array;
	}
	
	function markedTicketasRead($tid){
		$this->db->set('read',1);
		$this->db->where('tid',$tid);
		$this->db->update('tickets_msg');
		return true;
	}
}
?>