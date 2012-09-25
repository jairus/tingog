<?php
	function pre($arr){
		echo "<pre>";
		if(is_array($arr)) print_r($arr);
		else echo $arr;
		echo "</pre>";	
	}
	
	function returnNoAccessRight(){
		return "You do not have permission to access this page.";
	}
	
	function checkPermission($class=NULL,$function){
		#pre($_SESSION['access_levels']);
		$x = false;
		if($_SESSION['user_login']=='admin'){
			$x = true;
		}else{
			if(isset($_SESSION['access_levels']) && is_array($_SESSION['access_levels'])){
				foreach($_SESSION['access_levels'] as $k => $v){
					#pre($v);
					if(is_array($v)){
						if(in_array($function,$v)){
							$x = true;
							break;
						}else{
							$x = false;
						}
					}
				}
			}
		}
		#pre($x);
		return $x;
		#return true;
	}
	
	function array_user_level(){
		
		
		$array = array(
			'Admin Functions'=>array(
				'name'=>'Admin Functions',
				'class'=>'admin',
				'functions'=>array(
					'index'=>'Dashboard',
					'access'=>'User Levels',
					'accounts'=>'User Accounts',
					'adminListUserLevel'=>'List User Levels',
					'adminAddUserLevel'=>'Create User Levels',
					'adminEditUserLevel'=>'Update User Levels',
					'adminDeleteUserLevel'=>'Delete User Levels',
					'adminListUsers'=>'List Users',
					'adminAddUser'=>'Create Users',
					'adminEditUser'=>'Update Users',
					'adminDeleteUser'=>'Delete Users',
					'adminSetupBarangay'=>'Setup baranggay / facilities'
				),
			),
			
			'Dispatcher / City Access Functions'=>array(
				'name'=>'City Access Functions',
				'class'=>'cityaccess',
				'functions'=>array(
				 	//cityaccess
					'viewTicketList'=>'View Ticket List',
					'viewTicket'=>'View Ticket',
					'parkTicket'=>'Park Ticket',
					'dispatchTicket'=>'Dispatch Ticket',
					'internalMessage'=>'Internal Message',
					'sendReply'=>'Send Reply',
					'viewThread'=>'View Thread'
				
					#'cityDispatchTicket'=>'Dispatch Ticket',
					#'cityLabelAsSpam'=>'Label ticket as spam',
					#'cityLabelTicket'=>'Label Ticket: 1. Baranggay Facility 2. Nature of Report 3. Due Date',
					#'citySendSMS'=>'Send SMS (in ticket) through tingog platform',
					#'cityViewDispatch'=>'View Dispatched Tickets',
					#'cityViewUndispatch'=>'View Undispatched Tickets'
				)
			),
					
			'Department Functions'=>array(
				'name'=>'Department Functions',
				'class'=>'department',
				'functions'=>array(
					'depListTicket'=>'View Ticket List',
					'depviewticket'=>'View Ticket',
					'assign'=>'Assign Ticket',
					'returnTicket'=>'Return Ticket',
					'resolveTicket'=>'Resolve Ticket',
					'parkTicket'=>'Park Ticket',
					'internalMessage'=>'Internal Message',
					'sendReply'=>'Send Reply',
					'viewThread'=>'View Thread'
				
				#	'depLabelTicketFR'=>'Label Ticket as "False Report"',
				#	'depLabelTicketNFA'=>'Label Ticket as "Not for Action"',
				#	'depLabelTicketRT'=>'Label ticket as "Response Taken"'
				)
			),
					
			'Citizen Partner'=>array(
				'name'=>'Citizen Partner',
				'class'=>'citizen',
				'functions'=>array(
					'viewTicketList'=>'View Ticket List',
					'viewTicket'=>'View Ticket',
				)
			),
				
			'System User Functions'=>array(
				'name'=>'System User Functions',
				'class'=>'system',
				'functions'=>array(
					'userSetupEmailNotification'=>'Setup email notifications',
					'userSetupTextNotification'=>'Setup text notifications',
					'userUpdateProfile'=>'Update Profile / Password'
				)
			)
		);
		#$c = new department();
		#$class_methods = get_class_methods($c);
		#pre(test_get_class());
		#pre($this->router->class);
		return $array;
	}
	
	function std2arr($obj){
		$s = serialize($obj);
		$s = str_replace('O:8:"stdClass"', 'a', $s);
		return unserialize($s);
	}
	
	function return_access_name($key){
		$found = false;
		foreach(array_user_level() as $k=>$v){
			foreach($v['functions'] as $kk=>$vv){
				#pre($key.':'.$vv);
				if($key==$kk) $found = $vv;
			}
		}
		return $found;
	}
	
	function return_access_level(){
		$access = $this->admin->totalAccessLevel();
		#pre($access);
	}
	
	function zeroes($value, $places){
		$leading = "";
		if(is_numeric($value)){
			for($x = 1; $x <= $places; $x++){
				$ceiling = pow(10, $x);
				if($value < $ceiling){
					$zeros = $places - $x;
					for($y = 1; $y <= $zeros; $y++){
						$leading .= "0";
					}
					$x = $places + 1;
				}
			}
			$output = $leading . $value;
		}else{
			$output = $value;
		}
		return $output;
	}
	
	function array_tag($key=NULL){
		$array = array(
			0=>'',
			1=>'Resolved With Verification',
			2=>'Resolved Without Verification',
			3=>'Positive Feedback',
			4=>'Not for Action',
			5=>'Other Issues',
			6=>'Spam'
		);
		
		if($key){
			return $array[$key];
		}else{
			return $array;
		}
	}
	
	function word_limit($str, $limit){
		$str .= "";
		$str = trim($str);
		$l = strlen($str);
		$s = "";
		for($i=0; $i<$l; $i++)
		{
			$s .= $str[$i];
			if($limit>0&&(preg_match("/\s/", $str[$i])))
			{  
				if(!preg_match("/\s/", $str[$i+1]))
					$limit--;
				if(!$limit)
				{
					return $s."...";
					break;
				}
			}
		}
		return $s;
	}
	
	function array_parked($key=NULL){
		$array = array(
			'PF'=>'Positive Feedback',
			'NFA'=>'Not for Action',
			'OI'=>'Other Issues',
			'SP'=>'Spam'
		);
		
		if($key){
			return $array[$key];
		}else{
			return $array;
		}
	}
?>