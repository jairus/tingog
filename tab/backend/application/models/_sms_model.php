<?php
class SMS_Model extends CI_Model{
	function Admin_Model(){
		parent::__construct();
		$this->load->database();
	}
	function sendSMS($number, $sms){
		$sms = substr($sms, 0, 160);
		$sms = urlencode($sms);
		$url = "http://api.clickatell.com/http/sendmsg?user=DirectOpen&password=D0SMS911&api_id=3269103&to=$number$&text=$sms";
		echo $url;
		echo "<br>";
		echo file_get_contents($url);
		
	}
	function sendEmail($email, $message){
		
	}
	function getNameFromNumber($number){
		$name = "Anonymous";
		return $name;
	}
}
?>