<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sample extends CI_Controller {
	var $admin;
	public function __construct(){
		//load initial models and libraries that are needed for the controller
		parent::__construct();
		$this->load->database();
		$this->load->helper("functions_helper");
	}
	public function index(){
		$data = array();
		$data['page_title'] = 'Tingog Control Panel';
		$content = array();
		$content['content'] = $this->load->view('sample/main', $data, TRUE);
		$this->load->view('layout/main', $content);
	}
	
	function add(){
		if(!trim($_POST['username'])){
			echo "<a style='color:red'>Username is blank!</a>";
			exit();
		}
		else if(!trim($_POST['password'])){
			echo "<a style='color:red'>Password is blank!</a>";
			exit();
		}
		else{
			//save the user here
			// run a javascript here
			echo "<script>";
			echo "jQuery('#addform')[0].reset();";
			echo "alert('Save Successful!');";
			echo "</script>";
		}	
	}
	
	function viewusers(){
		for($i=0; $i<100; $i++){
			echo "lists $i<br>";
		}
	}

}
?>