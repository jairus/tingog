<?php
class SMS_Model extends CI_Model{
	function Admin_Model(){
		parent::__construct();
		$this->load->database();
	}
	function sendSMS($number, $sms, $tariff=""){
		//$sms = substr($sms, 0, 160);
		$sms = str_replace("\t", "", $sms);
		$sms = urlencode($sms);
		
		if($tariff!=""){
			$url = "http://74.86.63.102/~txtcircu/sms_out.php?telco=".$_GET['telco']."&tariff=".$tariff."&SUB_Mobtel=".$number."&SMS_Message_String=".$sms."&CSP_Txid=1";
		}
		else{
			$url = "http://74.86.63.102/~txtcircu/sms_out.php?telco=".$_GET['telco']."&tariff=1&SUB_Mobtel=".$number."&SMS_Message_String=".$sms."&CSP_Txid=1";
		}
		
		$sql = "insert into `sms_replies` set
			`url` = '".mysql_escape_string($url)."',
			`number` = '".mysql_escape_string($number)."',
			`message` = '".mysql_escape_string(urldecode($sms))."',
			`dateadded` = NOW()
		";
		
		echo "<pre>";
		echo "<b>Number: </b>".$number."<hr>";
		echo "<b>SMS Reply:</b>\n".htmlentities(urldecode($sms))."<hr>";
		echo "<b>DB Insert:</b>\n".htmlentities($sql)."<hr>";
		
		//echo $sql;
		$this->db->query($sql);
		
		if(!$_GET['nosms']){
			echo "SMS Sending Status: ".file_get_contents($url);
		}
		else{
			echo "SMS Not Sent!";
		}
		echo "</pre>";
		#$url = "";
		#$url = "http://api.clickatell.com/http/sendmsg?user=DirectOpen&password=D0SMS911&api_id=3269103&to=$number$&text=$sms";
		#echo $url;
		#echo "<br>";
		#echo file_get_contents($url);
		
	}
	function sendEmail($email, $message){
		
	}
	function getNameFromNumber($number){
		$name = "";
		return $name;
	}
	
	function recordTicket($no, $sms, $id){
		$this->db->set('SUB_Mobtel',$no);
		$this->db->set('SMS_Message_String 	',$sms);
		$this->db->set('CSP_Txid',$id);
		$this->db->set('date', 'NOW()', FALSE);
		$this->db->insert('sms_router');
		return true;
	}
	
	///<barangay> /<name>/<age>/<gender> 
	function createUser($no,$brgy,$name,$age,$gender){
		$this->db->set('mobile',$no);
		$this->db->set('name',$name);
		$this->db->set('barangay',$brgy);
		$this->db->set('age',$age);
		$this->db->set('gender',$gender);
		$this->db->insert('sms_user');
		return true;
	}
	
	function checkUser($no){
		$this->db->where('mobile',$no);
		$result = $this->db->get('sms_user');
		return $result->num_rows();
	}
}
?>