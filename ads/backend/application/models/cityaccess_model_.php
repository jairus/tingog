<?php
@session_start();
class Cityaccess_Model extends CI_Model{
	function Cityaccess_Model(){
		parent::__construct();
		$this->load->database();
	}
	
	function getTicketList($status=NULL){
		if($status) $this->db->where('status',$status);
		$this->db->order_by('id','desc');
		$result = $this->db->get('tickets');
		$r = $result->result_array();
		return $r;
	}
	
	function getTicketDetails($id){
		$this->db->where('id',$id);
		$result = $this->db->get('tickets');
		$r = $result->result_array();
		
		$this->db->set('read',1);
		$this->db->where('tid',$id);
		$this->db->update('tickets_msg');
		
		return $r;
	}
	
	function getCategories(){
		$sql = "select * from `categories` where `deleted`=0 ORDER BY `category`";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getCategoryNameById($id){
		$this->db->where('id',$id);
		$query = $this->db->get('categories');
		#return $query->result()->category;
		$r = $query->result_array();
		return $r[0]['category'];
	}
	
	function getDepartmentNameById($id){
		$this->db->where('id',$id);
		$query = $this->db->get('departments');
		#return $query->result()->category;
		$r = $query->result_array();
		return $r[0]['department'];
	}
	
	function getDepartments(){
		$sql = "select * from `departments` where `deleted`=0 ORDER BY `department`";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function ticketMessages($tid){
		#$this->db->where('tid',$tid);
		#$this->db->order_by("date", "asc");
		#$query = $this->db->get('tickets_msg');
		$array = array();
		
		$sql = "select a.*, b.user_login from `tickets_msg` as `a` left join `users` as `b` on (`a`.`user`=`b`.`id`) where `tid`='".mysql_escape_string($tid)."' order by `date` asc";
		$query = $this->db->query($sql);
		foreach ($query->result() as $std){
			$row = std2arr($std);
			
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
			`tag_park`='".$tag."',
			`last_update` = NOW()
			where `id` = '".$id."'
			";
		$query = $this->db->query($sql);
	}
	
	function dispatchTicket($id, $message, $category, $department, $brgy){
		if(!$id){
			return false;
		}
		$id = mysql_escape_string($id);
		$message = mysql_escape_string($message);
		$sql = "insert into `tickets_msg` set 
			`type`='Dispatch to ".$this->getDepartmentNameById($department)."',
			`msg` = '".$message."',
			`tid` = '".$id."',
			`user` = '".$_SESSION['user_id']."',
			`date` = NOW()
			";
		#pre($sql);
		$query = $this->db->query($sql);
		
		$sql = "update `tickets` set 
			`status`='dispatched',
			`barangay`='".$brgy."',
			`date` = NOW(),
			`category` = '".$category."',
			`department` = '".$department."',
			`last_update`=NOW()
			where `id` = '".$id."'
			";
		$query = $this->db->query($sql);
		#pre($sql);
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
	
	function tagTicket($id,$tag){
		if(!$id){
			return false;
		}
		$id = mysql_escape_string($id);
		$tag = mysql_escape_string($tag);
		
		$sql = "UPDATE `tickets` SET 
			`tag`='".$tag."',
			`last_update` = NOW()
			WHERE id='".$id."'
			";
		$query = $this->db->query($sql);
	}
	
	function dispatchMessage($id, $message){
		if(!$id){
			return false;
		}
		$id = mysql_escape_string($id);
		$message = mysql_escape_string($message);
		$sql = "insert into `tickets_msg` set 
			`type`='Dispatch Message',
			`msg` = '".$message."',
			`tid` = '".$id."',
			`user` = '".$_SESSION['user_id']."',
			`date` = NOW()
			";
		$query = $this->db->query($sql);
	}
	
	function closeTicket($id=NULL){
		if($id){
		
		}else{
			
		}
	}
	
	function updateMasterList($text){
		$this->db->set("name","cityMasterList");
		$check = $this->db->get("settings");
		
		$this->db->set("name","cityMasterList");
		$this->db->set("value",$text);
		if($check->num_rows()){
			$this->db->update("settings");
		}else{
			$this->db->insert("settings");
		}
		return $text;
	}
	
	function reOpenTicket($id){
		$this->db->set('status','new');
		$this->db->where('id',$id);
		$this->db->update('tickets');
	}
}
?>