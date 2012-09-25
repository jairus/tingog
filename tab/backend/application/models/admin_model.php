<?php
class Admin_Model extends CI_Model{
	function Admin_Model(){
		parent::__construct();
		$this->load->database();
	}
	
	function viewUser($id){
		$sql = "select * from `users` where `id`='".mysql_escape_string($id)."'";
		$q = $this->db->query($sql);
		$r = $q->result_array();
		return $r;
	}
	
	function totalAdminUser(){
		$count = $this->db->count_all_results('users');
		return $count;
	}
	
	function totalAccessLevel(){
		$array = array();
		
		$this->db->order_by("name", "asc");
		$query = $this->db->get('access_level');
		
		foreach ($query->result() as $row){
			$check_user = $this->db->get_where('users', array('access_level' => $row->id));
			#$r = $check_user->result();
			#pre($r);
			$options = array();
			$access = $this->db->get_where('access_level_option', array('access_level_id' => $row->id));
			foreach ($access->result() as $option){
				array_push($options,$option);
			}
			#$row['option'] = $options;
			array_push($array,array('access'=>$row,'options'=>$options,'users'=>$check_user->num_rows()));
		}
		#pre($array);
		return $array;
		
	}
	
	function createAccessLevel($name,$class,$array_function){
		$this->db->set('name', $name);
		$this->db->insert('access_level'); 
		$id = $this->db->insert_id();
		
		$data = array();
		if(is_array($array_function)){
			foreach($array_function as $k => $v){
				array_push($data, array(
					'access_level_id' => $id,
					'class' => $class,
					'function' => $v
				));
			}
		}
		$this->db->insert_batch('access_level_option', $data);
	}
	
	function addAccessLevel($name,$array){
		$id = $this->db->insert('access_level', array('name'=>$name));
		$id = $this->db->insert_id();
		
		$data = array();
		foreach($array as $k => $v){
			array_push($data,array('access_level_id'=>$id,'class'=>$v['class'],'function'=>$v['function']));
		}
		
		if(count($data)){
			$this->db->insert_batch('access_level_option', $data); 
		}
	}
	
	function checkUserAccessLevel($aid){
		$this->db->where('access_level',$aid);
		$result = $this->db->get('users');
		if($result->num_rows()){
			return $result->result_array();
		}else{
			return false;
		}
	}
	
	function deleteAccessLevel($aid){
		$this->db->delete('access_level', array('id' => $aid)); 
		$this->db->delete('access_level_option', array('access_level_id' => $aid)); 
		return true;
	}
	
	function adminUsers(){
		$array = array();
		
		$this->db->order_by("access_level", "asc");
		$query = $this->db->get('users');
		
		foreach ($query->result() as $row){
			$row = (std2arr($row));
			$get_access_name = $this->db->get_where('access_level', array('id' => $row['access_level']));
			$r = $get_access_name->result();
			$r = std2arr($r);
			$row['user_level'] = $r[0]['name'];
			array_push($array,$row);
		}
		
		return $array;
	}
	
	function addAdminUser($array){
		//user_login 	user_password 	access_level 	fname 	mname 	lname 	address
		#$this->db->set('name', $name);
		$check = $this->db->get_where('users', array('user_login' => $array['user_login']));
		if($check->num_rows() > 0){
			return $array['user_login']." already exists";
			exit();
		}else{
			if(is_array($array)){
				foreach($array as $k=>$v){
					$this->db->set($k, mysql_escape_string($v));
				}
			}
			$this->db->insert('users'); 
			$id = $this->db->insert_id();
			return "success";
		}
	}
	
	function getAdminUser($id){
		$result = $this->db->get_where('users', array('id' => $id));
		if($result->num_rows() > 0){
			$r = $result->result();
			return std2arr($r);
		}else{
			return array('error_message'=>'invalid user');
			exit();
		}
	}
	
	function editAdminUser($id,$array){
		if(is_array($array)){
			foreach($array as $k=>$v){
				$this->db->set($k, mysql_escape_string($v));
			}
		}
		$this->db->where('id',$id);
		$this->db->update('users');
		
		return true;
	}
	
	function getAccessLevel($id){
		$array = array();
		$accesslevel = array();
		
		$this->db->where("id", $id);
		$query = $this->db->get('access_level');
		
		foreach ($query->result() as $row){
			$access_name = $row->name;
			#pre($row->class);
			$options = array();
			$access = $this->db->get_where('access_level_option', array('access_level_id' => $row->id));
			foreach ($access->result() as $option){
				array_push($options,$option);
			}
			#$row['option'] = $options;
			array_push($array,array('access'=>$row,'options'=>$options));
		}
		#pre($options);
		$array = std2arr($array);
		if(is_array($array[0]['options'])){
			foreach($array[0]['options'] as $k=>$v){
				#pre($v);
				#$access[$v['access_level_id']] = $v['function'];
				array_push($accesslevel,$v);
			}
		}
		
		#pre($accesslevel);
		$accesslevel = array('name'=>$access_name,'functions'=>$accesslevel);
		return $accesslevel;
	}
	
	function editAccessLevel($id,$name,$functions){
		#pre($functions);
		#exit();
		$this->db->where('id', $id);
		$this->db->update('access_level', array('name'=>$name));
		
		
		$this->db->where('access_level_id', $id);
		$this->db->delete('access_level_option');
		
		$data = array();
		if(is_array($functions)){
			foreach($functions as $k => $v){
				array_push($data, array(
					'access_level_id' => $id,
					'class' => $v['class'],
					'function' => $v['function']
				));
			}
		}
		#pre($data);
		$this->db->insert_batch('access_level_option', $data);
		return "success";
	}
	
	function addTicket($array){
		foreach($array as $k => $v){
			$this->db->set($k,urldecode($v));
		}
		$this->db->set('date', 'NOW()', FALSE);
		$this->db->insert('tickets');
		
		return $this->db->insert_id();
	}
	
	function returnNameById($id){
		
	}
	
	
	/*
	function listAccessFunction(){
		$query = $this->db->get('access_level');
		$array = array();
		
		foreach ($query->result() as $row){
			#pre($row->id);
			#$access = $this->db->select('function')->from('access_level_option')->where('access_level_id', $row->id);
			$access = $this->db->get_where('access_level_option', array('access_level_id' => $row->id));
			foreach($access->result() as $r){
				#pre($row->id.' -> '.$r->function);
				array_push($array,$r);
			}
		}		
		
		return $array;
	}
	*/
	
	function ticketUpdateStatus($tid,$status){
		$this->db->where('id',$tid);
		$this->db->update('tickets', array('status'=>$status));
	}
	
	function ticketWriteMsg($tid,$array){
		foreach($array as $k => $v){
			$this->db->set($k,urldecode($v));
		}
		$this->db->set('user',$_SESSION['user_id']);
		$this->db->set('date', 'NOW()', FALSE);
		$this->db->insert('tickets_msg');
	}
	
	function ticketWriteMsgFromSMS($array){
		foreach($array as $k => $v){
			$this->db->set($k,urldecode($v));
		}
		$this->db->set('user',0);
		$this->db->set('date', 'NOW()', FALSE);
		$this->db->insert('tickets_msg');
	}
	
	function getDepartments($id=NULL){
		if($id!=NULL) $sql = "select * from `departments` where id='".$id."' ORDER BY `department`";
		else $sql = "select * from `departments` where `deleted`=0 ORDER BY `department`";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function checkDepartment($id=NULL,$name=NULL){
		$sql = "SELECT * FROM `departments` WHERE `department`='".$name."' AND `id`!='".$id."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $name." already exists";
		}else{
			return "available";
		}
	}
	
	function updateDepartmentName($id,$name,$head){
		$this->db->where('id',$id);
		$this->db->update('departments', array('department'=>$name,'head'=>$head));
		return true;
	}
	
	function insertDepartment($name,$head){
		$this->db->set('department', $name);
		$this->db->set('head', $head);
		$this->db->insert('departments'); 
		return true;
	}
	
	function checkDepartmentTicketNo($id){
		$this->db->where('department',$id);
		$result = $this->db->get('tickets');
		return std2arr($result->result_array());
	}
	
	function checkDepartmentUserNo($id){
		$this->db->where('department',$id);
		$result = $this->db->get('users');
		return std2arr($result->result_array());
	}
	
	function checkDepartmentPersonnelNo($id){
		$this->db->where('department',$id);
		$result = $this->db->get('personnel');
		return std2arr($result->result_array());
	}
	
	function deleteCategory($id){
		$this->db->delete('categories', array('id' => $id)); 
		return true;
	}
	
	function deleteDepartment($id){
		$this->db->delete('departments', array('id' => $id)); 
		return true;
	}
	
	function getCategory($id=NULL){
		if($id!=NULL) $sql = "select * from `categories` where `id`='".$id."' ORDER BY `category`";
		else $sql = "select * from `categories` where `deleted`=0 ORDER BY `category`";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function checkCategoryTicketNo($id){
		#$this->db->where('category',$id);
		$result = $this->db->query("SELECT * FROM tickets WHERE `category`='".$id."' AND `status`!='closed'");
		return std2arr($result->result_array());
	}
	
	function checkCategory($id=NULL,$name=NULL){
		$sql = "SELECT * FROM `categories` WHERE `category`='".$name."' AND `id`!='".$id."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $name." already exists";
		}else{
			return "available";
		}
	}
	
	function insertCategory($name){
		$this->db->set('category', $name);
		$this->db->insert('categories'); 
		return true;
	}
	
	function updateCategoryName($id,$name){
		$this->db->where('id',$id);
		$this->db->update('categories', array('category'=>$name));
		return true;
	}
	
	/*ISSUES*/
	function getIssues($id=NULL){
		if($id!=NULL) $sql = "select * from `issues` where `id`='".$id."' ORDER BY `issue`";
		else $sql = "select * from `issues` where `deleted`=0 ORDER BY `issue`";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function checkIssues($id=NULL,$name=NULL){
		$sql = "SELECT * FROM `issues` WHERE `issue`='".$name."' AND `id`!='".$id."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $name." already exists";
		}else{
			return "available";
		}
	}
	
	function insertIssue($name){
		$this->db->set('issue', $name);
		$this->db->insert('issues'); 
		return true;
	}
	
	function updateIssueName($id,$name){
		$this->db->where('id',$id);
		$this->db->update('issues', array('issue'=>$name));
		return true;
	}
	
	function checkIssueTicketNo($id){
		#$this->db->where('issue',$id);
		$result = $this->db->query("SELECT * FROM tickets WHERE `issue`='".$id."' AND `status`!='closed'");
		return std2arr($result->result_array());
	}
	
	function deleteIssue($id){
		$this->db->delete('issues', array('id' => $id)); 
		return true;
	}

	/*PERSONNEL*/
	function getPersonnel($id=NULL){
		if($id!=NULL) $sql = "select * from `personnel` where `id`='".$id."'";
		else $sql = "select * from `personnel` ORDER BY `person`";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function checkPersonnel($id=NULL,$name=NULL){
		$sql = "SELECT * FROM `personnel` WHERE `person`='".$name."' AND `id`!='".$id."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $name." already exists";
		}else{
			return "available";
		}
	}
	
	function insertPersonnel($name,$department,$mobile){
		$this->db->set('person', $name);
		$this->db->set('department', $department);
		$this->db->set('mobile', $mobile);
		$this->db->insert('personnel'); 
		return true;
	}
	
	function updatePersonnel($id,$name,$department,$mobile){
		$this->db->where('id',$id);
		$this->db->update('personnel', array('person'=>$name,'department'=>$department,'mobile'=>$mobile));
		return true;
	}
	
	function checkPersonnelTicketNo($id){
		$result = $this->db->query("SELECT * FROM tickets WHERE (`assign1`='".$id."' OR `assign2`='".$id."') AND (`status`!='closed')");
		return std2arr($result->result_array());
	}
	
	function deletePersonnel($id){
		$this->db->delete('personnel', array('id' => $id));
		return true;
	}
	
	function getMasterList(){
		$this->db->set("name","cityMasterList");
		$result = $this->db->get("settings");
		if($result->num_rows()){
			$r = $result->result_array();
			return $r[0]['value'];
		}else{
			return "";
		}
	}
	
	function getBarangay($id=0){
		if($id){
			$this->db->where("id", $id); 
			$result = $this->db->get('barangay');
		}else{
			$this->db->order_by("name", "asc"); 
			$result = $this->db->get('barangay');
		}
		return std2arr($result->result_array());
	}
	
	function createBarangay($name,$long,$lat){
		if($name && $long && $lat){
			$check = $this->db->get_where('barangay', array('name'=>$name, 'long'=>$long, 'lat'=>$lat));
			if($check->num_rows()){
				$r = $check->result_array();
				return $r[0]['id'];
			}else{
				$this->db->set("name",$name);
				$this->db->set("long",$long);
				$this->db->set("lat",$lat);
				$result = $this->db->insert("barangay");
				return $result->insert_id();
			}
		}else{
			return false;
		}
	}
	
	function verifyClosedTicket(){
		$daysToExp = 7;
		$query = $this->db->query("SELECT * FROM tickets WHERE `status`='parked' OR `status`='resolved'");
		if($query->num_rows()>0){
			foreach ($query->result() as $std){
				$std = std2arr($std);
				$exp = (strtotime($std['last_update']) + (86400*$daysToExp));
				if(time()>=$exp){
					$this->db->set("status","closed");
					$this->db->where("id",$std['id']);
					$this->db->update("tickets");
				}
			}
		}
	}
}
?>