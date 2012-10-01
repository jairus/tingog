<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
	var $admin;
	var $sms;
	var $citymodel;
	public function __construct(){
		//load initial models and libraries that are needed for the controller
		parent::__construct();
		$this->load->database();
		$this->load->model("admin_model");
		$this->admin = new Admin_Model();
		$this->load->model("sms_model");
		$this->sms = new SMS_Model();
		$this->load->model("cityaccess_model");
		$this->citymodel = new Cityaccess_Model();
		$this->load->helper("functions_helper");
	}
	
	public function index(){
		$data = array();
		$data['page_title'] = 'Tingog Control Panel';
		$content = array();
		$content['content'] = $this->load->view('admin/main', $data, TRUE);
		$this->load->view('layout/main', $content);
	}
	
	public function viewUser($id){
		$data = array();
		$data['page_title'] = 'User Account';
		$data['user'] = $this->admin->viewUser($id);
		$content = array();
		$content['content'] = $this->load->view('admin/viewuser', $data, TRUE);
		$this->load->view('layout/main', $content);
	}
	
	public function access($action=NULL,$delete_id=NULL){
		$data = array();
		$data['page_title'] = 'User Levels';
		if(checkPermission(get_class($this), __FUNCTION__)){
			#$data['total_access_level'] = $this->admin->totalAccessLevel();
			$access = $this->admin->totalAccessLevel();
			#$this->load->library('Snoopy');
			$data['total_access_level'] = count($access);
			$data['accesslevel'] = $access;
			
			$content = array();
			
			/* add new user level */
			if(isset($_REQUEST['Submit'])){
				$access = array();
				if(isset($_REQUEST['functions'])){
					foreach($_REQUEST['functions'] as $k => $v){
						array_push($access,$v);
					}
				}
				#pre($access);
				$function_list = array_user_level();
				if(isset($_REQUEST['accessname']) && strlen($_REQUEST['accessname'])){
					$array = array();
					foreach($access as $k => $v){
						foreach($function_list as $fk => $fv){
							if(array_key_exists($v,$fv['functions'])){
								#$array = pre($v.' '.$fv['class']);
								array_push($array,array('function'=>$v,'class'=>$fv['class']));
							}
						}
					}
					$this->admin->addAccessLevel($_REQUEST['accessname'],$array);
				}else{
					$data['error_message'] = "Please enter the Access Level Name.";
				}
			}
			/* end of add new user level*/
			
			#$access_list = $this->admin->listAccessFunction();
			#pre($access_list);
			#pre($access);
			
			$content['content'] = $this->load->view('admin/accesslevel', $data, TRUE);
			$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function accessLevelList(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			
			$access = $this->admin->totalAccessLevel();
			#$this->load->library('Snoopy');
			$data['total_access_level'] = count($access);
			$data['accesslevel'] = $access;
			
			$this->load->view('admin/accesslevel_list', $data);
			#$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function accessLevelAdd(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$this->load->view('admin/accesslevel_add', $data);
			#$this->load->view('layout/main', $content);
		}else{
			
		}
	}
	
	function adminAccessLevelEdit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Update Access Level';
			
			#$access = $this->admin->totalAccessLevel();
			#$data['total_access_level'] = count($access);
			#$data['accesslevel'] = $access;
			
			$accesslevel = $this->admin->getAccessLevel($id);
			#pre($accesslevel);
			$data['id'] = $id;
			$data['accesslevel_name'] = $accesslevel['name'];
			$data['accesslevel_data'] = $accesslevel['functions'];
			#$data['accesslevel_data'] = array('class'=>'admin','functions'=>$accesslevel['functions']);
			#pre($accesslevel_data);
			
			$content['content'] = $this->load->view('admin/accesslevel_edit', $data, TRUE);
			$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function adminAccessLevelEditSubmit($id=NULL){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$array = array();
			$level_types = array('admin','cityaccess','department','citizen');
			foreach($level_types as $type){
				if(isset($_POST[$type])){
					#pre($_POST[$type]);
					#$access = std2arr($this->admin->totalAccessLevel());
					$access = array_user_level();
					#pre("hello");
					foreach($access as $a => $f){
						#pre();
						foreach($f['functions'] as $function => $name){
							if(isset($_POST[$f['class']][$function]) && ($f['class']==$type)){
								#pre($function.''.$f['class']);
								#pre($_POST[$f['class']][$function]);
								#pre($type);
								array_push($array,array('function'=>$function,'class'=>$f['class']));
							}
						}
					}
				}
			}
			#pre($array);
			
			$result = $this->admin->editAccessLevel($id,$_POST['accessname'],$array);
			if($result=="success"){
				// run a javascript here
				echo "<script>";
				#echo "jQuery('#editform')[0].reset();";
				echo "alert('".$_POST['accessname']." successfully updated!');";
				echo "</script>";
			}else{
				echo "<a style='color:red'>".$result."</a>";
				exit();
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function accessDeleteSubmit($id){
		$get_access = $this->admin->getAccessLevel($id);
		#pre($get_access);
		if(isset($get_access['name'])){
			$check = $this->admin->checkUserAccessLevel($id);
			if($check===false){
				$this->admin->deleteAccessLevel($id);
				echo "<script>";
				echo "viewAccess();";
				echo "</script>";
			}else{
				echo "<a>Unable to delete this Access Level. Please verify that there are no users using this.</a>";
			}
		}else{
			echo "<script>";
			echo "alert('Invalid Access Level');";
			echo "</script>";
		}
	}
	
	
	function adminUserAccounts(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'User Accounts';
			
			$access = $this->admin->totalAccessLevel();
			#$this->load->library('Snoopy');
			$data['total_access_level'] = count($access);
			$data['accesslevel'] = $access;
			
			$content['content'] = $this->load->view('admin/user_accounts', $data, TRUE);
			$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function adminViewUserAccounts(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'User Accounts';
			
			$data['adminusers'] = $this->admin->adminUsers();
			
			$this->load->view('admin/user_list', $data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function adminCreateNewAccount(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Create New User Account';
			
			$access = $this->admin->totalAccessLevel();
			$data['total_access_level'] = count($access);
			$data['accesslevel'] = $access;
			
			$data['departments'] = $this->admin->getDepartments();
			$this->load->view('admin/user_add', $data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function adminCreateNewAccountSubmit(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			if(!trim($_POST['username'])){
				echo "<a style='color:red'>Username is blank!</a>";
				exit();
			}
			else if(!trim($_POST['user_password1'])){
				echo "<a style='color:red'>Password is blank!</a>";
				exit();
			}
			else if(trim($_POST['user_password1'])!=trim($_POST['user_password2'])){
				echo "<a style='color:red'>Retype password do not match!</a>";
				exit();
			}
			
			else{
				//save the user here
				#pre($_POST);
				$array = array(
					'user_login'=>$_POST['username'],
					'user_password'=>md5($_POST['user_password1']),
					'access_level'=>$_POST['access_level'],
					'fname'=>$_POST['fname'],
					'mname'=>$_POST['mname'],
					'lname'=>$_POST['lname'],
					'address'=>$_POST['address'],
					'department'=>$_POST['department_id'],
					'mobile'=>$_POST['mobile'],
					'email'=>$_POST['email']
				);
				
				$result = $this->admin->addAdminUser($array);
				if($result=="success"){
					// run a javascript here
					echo "<script>";
					echo "jQuery('#addform')[0].reset();";
					echo "alert('".$_POST['username']." successfully created!');";
					echo "</script>";
				}else{
					echo "<a style='color:red'>".$result."</a>";
					exit();
				}
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}

	function adminEditAccount($id=NULL){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Update User Account';
			
			$access = $this->admin->totalAccessLevel();
			#$data['total_access_level'] = count($access);
			$data['accesslevel'] = $access;
			
			$data['user_data'] = $this->admin->getAdminUser($id);
			$data['departments'] = $this->admin->getDepartments();
			
			$content['content'] = $this->load->view('admin/user_edit', $data, TRUE);
			$this->load->view('layout/main', $content);
			#$this->load->view('admin/user_edit', $data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function adminEditAccountSubmit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			//save the user here
			$array = array(
				'access_level'=>$_POST['access_level'],
				'fname'=>$_POST['fname'],
				'mname'=>$_POST['mname'],
				'lname'=>$_POST['lname'],
				'address'=>$_POST['address'],
				'department'=>$_POST['department_id'],
				'mobile'=>$_POST['mobile'],
				'email'=>$_POST['email']
			);
			if(isset($_POST['user_password1'])&& strlen($_POST['user_password1'])){
				if($_POST['user_password1']==$_POST['user_password2']){
					$array['user_password'] = md5($_POST['user_password1']);
				}else{
					echo "<a style='color:red'>New Password not matched.</a>";
					exit();
				}
			}
			
			$result = $this->admin->editAdminUser($id,$array);
			if($result){
				// run a javascript here
				echo "<script>";
				#echo "jQuery('#editform')[0].reset();";
				echo "alert('User Account successfully updated!');";
				echo "</script>";
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function accounts(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'User Accounts';
			
			if(checkPermission(get_class($this), __FUNCTION__)){
				$data['total'] = count($this->admin->adminUsers());
				
				$content = array();
				$content['content'] = $this->load->view('admin/user_accounts', $data, TRUE);
				$this->load->view('layout/main', $content);
			}else{
				$content['content'] = returnNoAccessRight();
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function departments(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Concerned Office CMS';
			
			$data['table_titles'] = array('ID','Name');
			$data['table_width'] = array('id'=>30,'name'=>200);
			
			$list = std2arr($this->admin->getDepartments());
			$data['total'] =  count($list);
			
			$content['content'] = $this->load->view('admin/departments', $data, TRUE);
			$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function departmentsList(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Concerned Office CMS';
			$data['content'] = "Under construction";
			
			$data['table_titles'] = array('Name','Head');
			$data['table_width'] = array('name'=>200,'head'=>200);
			
			$list = std2arr($this->admin->getDepartments());
			
			$i=0;
			$r = array();
			$data['delete_method'] = 'departmentDeleteSubmit';
			foreach($list as $k=>$v){
				#$r[$i]['id'] = $v['id'];
				#$r[$i]['name'] = $v['department'];
				$v['name'] = $v['department'];
				$v['edit_link'] = "/admin/departmentsEdit/".$v['id'];
				$head = std2arr($this->admin->getPersonnel($v['head']));
				if(count($head)) $v['head'] = $head[0]['person'];
				else $v['head'] = "";
				#$v['head'] = $head[]
				#$v['users'] = rand();
				
				$v['tickets'] = count($this->admin->checkDepartmentTicketNo($v['id']));
				if($v['tickets']!=0){
					$v['delete_unable_msg'] = 'You cannot delete this Concerned Office because there are Reports using this.';
				}
				
				$v['users'] = count($this->admin->checkDepartmentUserNo($v['id']));
				if($v['users']!=0){
					$v['delete_unable_msg'] = 'You cannot delete this Concerned Office because there are Users using this.';
				}
				
				$v['personnel'] = count($this->admin->checkDepartmentPersonnelNo($v['id']));
				if($v['personnel']!=0){
					$v['delete_unable_msg'] = 'You cannot delete this Concerned Office because there are Personnel on it.';
				}
			
				
				array_push($r,$v);
				$i++;
			}
			$data['list'] = $r;
			
			$this->load->view('admin/option_list', $data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function departmentsAdd(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['personnel'] = std2arr($this->admin->getPersonnel(false));
			$this->load->view('admin/department_add',$data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	} 
	
	public function departmentsAddSubmit(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			if(isset($_POST['name'])){
				$name = $_POST['name'];
				$result = $this->admin->checkDepartment($name);
				if($result=="available"){
					$this->admin->insertDepartment($name,$_POST['head']);
					// run a javascript here
					echo "<script>";
					#echo "jQuery('#editform')[0].reset();";
					echo "alert('".$_POST['name']." successfully created!');";
					echo "</script>";
				}else{
					echo "<a style='color:red'>".$result."</a>";
					exit();
				}
			}else{
				echo "<a style='color:red'>Please enter Concerned Office Name.</a>";
				exit();
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function departmentsEdit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Update Concerned Office';
			$r = std2arr($this->admin->getDepartments($id));
			#pre($query);
			$data['id'] = $id;
			$data['name'] = $r[0]['department'];
			$data['head'] = $r[0]['head'];
			$data['personnel'] = std2arr($this->admin->getPersonnel(false));
			$content['content'] = $this->load->view('admin/department_edit',$data,TRUE);
			$this->load->view('layout/main',$content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function departmentsEditSubmit($id){
		#pre($_POST);
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Update Concerned Office';
			
			$data['id'] = $id;
			#$data['name'] = $_POST['name'];
			#pre($data);
			$result = $this->admin->checkDepartment($id,$_POST['name']);
			if($result=="available"){
				$this->admin->updateDepartmentName($id,$_POST['name'],$_POST['head']);
				echo "<script>";
				#echo "jQuery('#editform')[0].reset();";
				echo "alert('".$_POST['name']." successfully updated!');";
				echo "</script>";
			}else{
				echo "<a style='color:red'>".$result."</a>";
				exit();
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function departmentDeleteSubmit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$v['tickets'] = count($this->admin->checkDepartmentTicketNo($v['id']));
			if($v['tickets']!=0){
				echo '<a style="color:red">You cannot delete this Concerned Office because there are Reports on it.</a>';
				exit();
			}
			
			$v['users'] = count($this->admin->checkDepartmentUserNo($v['id']));
			if($v['users']!=0){
				echo '<a style="color:red">You cannot delete this Concerned Office because there are Users on it.</a>';
				exit();
			}
			
			$v['personnel'] = count($this->admin->checkDepartmentPersonnelNo($v['id']));
			if($v['personnel']!=0){
				echo '<a style="color:red">You cannot delete this Concerned Office because there are Personnel on it.</a>';
				exit();
			}
			
			$this->admin->deleteDepartment($id);
			echo "<script>";
			echo "viewDepartments();";
			echo "alert('Concerned Office successfully deleted!');";
			echo "</script>";
			
		}else{
			echo returnNoAccessRight();
		}
	}
	
	public function categories(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Categories CMS';
			
			$data['table_titles'] = array('ID','Name');
			$data['table_width'] = array('id'=>30,'name'=>200);
			
			$list = std2arr($this->admin->getCategory());
			$data['total'] =  count($list);
			
			$content['content'] = $this->load->view('admin/categories', $data, TRUE);
			$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function categoryList(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Categories CMS';
	
			$data['table_titles'] = array('Name');
			$data['table_width'] = array('name'=>200);
			$data['delete_method'] = 'categoryDeleteSubmit';
			
			$list = std2arr($this->admin->getCategory());
			
			$i=0;
			$r = array();
			foreach($list as $k=>$v){
				#$r[$i]['id'] = $v['id'];
				#$r[$i]['name'] = $v['department'];
				$v['name'] = $v['category'];
				$v['edit_link'] = "/admin/categoryEdit/".$v['id'];
				#$v['delete_link'] = "/admin/categoryDelete/".$v['id'];
				$v['tickets'] = $this->admin->checkCategoryTicketNo($v['id']);
				if($v['tickets']){
					$v['delete_unable_msg'] = "You cannot delete this Category because there are Reports using this.";
				}
				
				array_push($r,$v);
				$i++;
			}
			$data['list'] = $r;
			
			$this->load->view('admin/option_list', $data);
			#$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function categoryAdd(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$this->load->view('admin/category_add',$data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function categoryAddSubmit(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			if(isset($_POST['name'])){
				$name = $_POST['name'];
				$result = $this->admin->checkCategory($name);
				if($result=="available"){
					$this->admin->insertCategory($name);
					// run a javascript here
					echo "<script>";
					#echo "jQuery('#editform')[0].reset();";
					echo "alert('".$_POST['name']." successfully created!');";
					echo "</script>";
				}else{
					echo "<a style='color:red'>".$result."</a>";
					exit();
				}
			}else{
				echo "<a style='color:red'>Please enter Category Name.</a>";
				exit();
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function categoryEdit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Update Category';
			$r = std2arr($this->admin->getCategory($id));
			#pre($query);
			$data['id'] = $id;
			$data['name'] = $r[0]['category'];
			$content['content'] = $this->load->view('admin/category_edit',$data,TRUE);
			$this->load->view('layout/main',$content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function categoryEditSubmit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Update Category';
			
			$data['id'] = $id;
			#$data['name'] = $_POST['name'];
			#pre($data);
			$result = $this->admin->checkCategory($id,$_POST['name']);
			if($result=="available"){
				$this->admin->updateCategoryName($id,$_POST['name']);
				echo "<script>";
				#echo "jQuery('#editform')[0].reset();";
				echo "alert('".$_POST['name']." successfully updated!');";
				echo "</script>";
			}else{
				echo "<a style='color:red'>".$result."</a>";
				exit();
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function categoryDeleteSubmit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$check = $this->admin->checkCategoryTicketNo($id);
			if(count($check)){
				echo '<a style="color:red">You cannot delete this Category because there are Reports using this.</a>';
				exit();
			}else{
				$this->admin->deleteCategory($id);
				echo "<script>";
				echo "viewCat();";
				echo "alert('Category successfully deleted!');";
				echo "</script>";
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}

	public function issues(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Issues CMS';
			
			$data['table_titles'] = array('Name');
			$data['table_width'] = array('name'=>200);
			
			$list = std2arr($this->admin->getIssues());
			$data['total'] =  count($list);
			
			$content['content'] = $this->load->view('admin/issues', $data, TRUE);
			$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function issueList(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Issues CMS';
	
			$data['table_titles'] = array('Name');
			$data['table_width'] = array('name'=>200);
			$data['delete_method'] = 'issueDeleteSubmit';
			
			$list = std2arr($this->admin->getIssues());
			
			$i=0;
			$r = array();
			foreach($list as $k=>$v){
				#$r[$i]['id'] = $v['id'];
				#$r[$i]['name'] = $v['department'];
				$v['name'] = $v['issue'];
				$v['edit_link'] = "/admin/issueEdit/".$v['id'];
				
				$check = $this->admin->checkIssueTicketNo($v['id']);
				if(count($check)){
					$v['delete_unable_msg'] = "You cannot delete this Issue because there are Reports using this.";
				}
				
				array_push($r,$v);
				$i++;
			}
			$data['list'] = $r;
			
			$this->load->view('admin/option_list', $data);
			#$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function issueDeleteSubmit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$check = $this->admin->checkIssueTicketNo($id);
			if(count($check)){
				echo "<a style='color:red'>You cannot delete this Issue because there are Reports using this.</a>";
				exit();
			}else{
				$this->admin->deleteIssue($id);
				echo "<script>";
				echo "viewIssues();";
				echo "alert('Issue successfully deleted!');";
				echo "</script>";
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function issueAdd(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$this->load->view('admin/issue_add',$data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function issueAddSubmit(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			if(isset($_POST['name'])){
				$name = $_POST['name'];
				$result = $this->admin->checkIssues(false,$name);
				if($result=="available"){
					$this->admin->insertIssue($name);
					// run a javascript here
					echo "<script>";
					#echo "jQuery('#editform')[0].reset();";
					echo "alert('".$_POST['name']." successfully created!');";
					echo "</script>";
				}else{
					echo "<a style='color:red'>".$result."</a>";
					exit();
				}
			}else{
				echo "<a style='color:red'>Please enter Category Name.</a>";
				exit();
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function issueEdit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Update Issue';
			$r = std2arr($this->admin->getIssues($id));
			#pre($query);
			$data['id'] = $id;
			$data['name'] = $r[0]['issue'];
			$content['content'] = $this->load->view('admin/issue_edit',$data,TRUE);
			$this->load->view('layout/main',$content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function issueEditSubmit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Update Issue';
			
			$data['id'] = $id;
			#$data['name'] = $_POST['name'];
			#pre($data);
			$result = $this->admin->checkIssues($id,$_POST['name']);
			if($result=="available"){
				$this->admin->updateIssueName($id,$_POST['name']);
				echo "<script>";
				#echo "jQuery('#editform')[0].reset();";
				echo "alert('".$_POST['name']." successfully updated!');";
				echo "</script>";
			}else{
				echo "<a style='color:red'>".$result."</a>";
				exit();
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function personnel(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Personnel CMS';
			
			$data['table_titles'] = array('ID','Name');
			$data['table_width'] = array('id'=>30,'name'=>200);
			
			$list = std2arr($this->admin->getPersonnel());
			$data['total'] =  count($list);
			
			$content['content'] = $this->load->view('admin/personnel', $data, TRUE);
			$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function personnelList(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Personnel CMS';
	
			$data['table_titles'] = array('Name','Mobile','Concerned Office');
			$data['table_width'] = array('name'=>200,'mobile'=>150,'department'=>200);
			$data['delete_method'] = 'personnelDeleteSubmit';
			
			$list = std2arr($this->admin->getPersonnel());
			
			$i=0;
			$r = array();
			foreach($list as $k=>$v){
				#$r[$i]['id'] = $v['id'];
				#$r[$i]['name'] = $v['department'];
				$v['name'] = $v['person'];
				$check = $this->admin->checkPersonnelTicketNo($v['id']);
				if(count($check)){
					$v['delete_unable_msg'] = "You cannot delete this Personnel because there are still Unclosed Reports assigned to it.";
				}
				#$v['department'] = $v['department'];
				$dep = std2arr($this->admin->getDepartments($v['department']));
				if(isset($dep[0]['department'])) $v['department'] = $dep[0]['department'];
				else $v['department'] = "";
				#$v['department'] = $dep[''];
				#pre($dep);
				$v['edit_link'] = "/admin/personnelEdit/".$v['id'];
				array_push($r,$v);
				$i++;
			}
			$data['list'] = $r;
			
			$this->load->view('admin/option_list', $data);
			#$this->load->view('layout/main', $content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function personnelAdd(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['department'] = std2arr($this->admin->getDepartments(NULL));
			$this->load->view('admin/personnel_add',$data);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function personnelAddSubmit(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			if(isset($_POST['name'])){
				$name = $_POST['name'];
				$result = $this->admin->checkPersonnel(false,$name);
				if($result=="available"){
					$this->admin->insertPersonnel($name,$_POST['department'],$_POST['mobile']);
					// run a javascript here
					echo "<script>";
					#echo "jQuery('#editform')[0].reset();";
					echo "alert('".$_POST['name']." successfully created!');";
					echo "</script>";
				}else{
					echo "<a style='color:red'>".$result."</a>";
					exit();
				}
			}else{
				echo "<a style='color:red'>Please enter Personnel Name.</a>";
				exit();
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function personnelEdit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Update Personnel';
			$r = std2arr($this->admin->getPersonnel($id));
			#pre($query);
			$data['id'] = $id;
			$data['name'] = $r[0]['person'];
			$data['mobile'] = $r[0]['mobile'];
			$data['did'] = $r[0]['department'];
			$data['department'] = std2arr($this->admin->getDepartments(NULL));
			$content['content'] = $this->load->view('admin/personnel_edit',$data,TRUE);
			$this->load->view('layout/main',$content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function personnelEditSubmit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Update Personnel';
			
			$data['id'] = $id;
			#$data['name'] = $_POST['name'];
			#pre($data);
			$result = $this->admin->checkPersonnel($id,$_POST['name']);
			if($result=="available"){
				#$department = "";
				$this->admin->updatePersonnel($id,$_POST['name'],$_POST['department'],$_POST['mobile']);
				echo "<script>";
				#echo "jQuery('#editform')[0].reset();";
				echo "alert('".$_POST['name']." successfully updated!');";
				echo "</script>";
			}else{
				echo "<a style='color:red'>".$result."</a>";
				exit();
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	public function personnelDeleteSubmit($id){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$check = $this->admin->checkPersonnelTicketNo($id);
			if(count($check)){
				echo "<a style='color:red'>You cannot delete this Personnel because there are still Unclosed Reports assigned to it.</a>";
				exit();
			}else{
				$this->admin->deletePersonnel($id);
				echo "<script>";
				echo "viewPersonnel();";
				echo "alert('Personnel successfully deleted!');";
				echo "</script>";
			}
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	
	
	function barangay(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			$data = array();
			$data['page_title'] = 'Barangay Listing';
			
			$data['list'] = $this->admin->getBarangay();
			$content['content'] = $this->load->view('admin/barangay_list',$data,TRUE);
			$this->load->view('layout/main',$content);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	function barangayDeleteSubmit(){
		if(checkPermission(get_class($this), __FUNCTION__)){
			pre($_REQUEST);
		}else{
			$content['content'] = returnNoAccessRight();
		}
	}
	
	/************************************************************************************************* SMS **************************************************************************************/
	
	public function smsReply($number,$array, $mun){
		$ticket_id = trim($array[0]);
		$msg = trim($array[1]);
		$name = $this->sms->getNameFromNumber($number);
		
		if(!$ticket_id && !$msg){
			$text = "Para mag-reply sa Tingog, i-text ang TINGOG REP<report#>/<message>. Ex. TINGOG REP ".$mun."12345/ salamat! 1P/txt Maaari ding alamin ang updates sa iyong report sa website ng TINGOG 2015 http://www.tingog.ph/tab/.";
			$this->sms->sendSMS($number,$text);
			return false;
		}
		else if(!$ticket_id || !$msg){
			if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
				$text = "Mali ang format na iyong ginamit.I-text ang TINGOG REP<report#>/<message>.Ex. TINGOG REP 12345/ salamat!
Para sa listahan ng keywords,reply TINGOG HELP.P1/txt.";
			}
			else{
				$text = "Sorry, mali ang format na iyong ginamit. 

Para mag-reply, i-text ang TINGOG REP<report#>/<message>. Ex. TINGOG REP 12345/ salamat! Para sa listahan ng iba pang keywords, text TINGOG HELP. P1/txt.
";			
			}
			$this->sms->sendSMS($number,$text);
			return false;
		}
		else{
			$ticket_id = preg_replace("/[^0-9]/iUs","", $ticket_id);
			$ticket = std2arr($this->citymodel->getTicketDetails($ticket_id));
			if(!isset($ticket[0])){
				if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
					$text = "Sorry, mali ang report number. I-check ang report number. Para mag-reply, i-text ang TINGOG REP<report#>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt";
				}
				else{
					$text = "Sorry, mali ang report number. I-check ang report number na ibinigay sa iyo.  Para mag-reply, i-text ang TINGOG REP <report#><report code>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
				}
				$this->sms->sendSMS($number,$text);
				return false;
			}else{
				if($ticket[0]['number']!=$number){
					if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
						$text = "Sorry, mali ang report number. I-check ang report number. Para mag-reply, i-text ang TINGOG REP<report#>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt";
					}
					else{
						$text = "Sorry, mali ang report number. I-check ang report number na ibinigay sa iyo.  Para mag-reply, i-text ang TINGOG REP <report#><report code>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt.
	
Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
					}
					$this->sms->sendSMS($number,$text);
					return false;
				}
				else{
					if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
						$text = "Salamat sa iyong mensahe. Ikaw ay makatatanggap ng sagot mula sa TINGOG 2015 maya-maya lamang. 

Para sa listahan ng keywords, reply TINGOG HELP.P1/txt";
					}
					else{
						$text = "Salamat sa iyong mensahe. Ikaw ay makakatanggap ng sagot mula sa TINGOG 2015 maya-maya lamang. P1/txt.
	
Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
					}
					$this->sms->sendSMS($number,$text);
					
				}
			}
		}
		$this->admin->ticketWriteMsgFromSMS(array('tid'=>$ticket_id,'msg'=>$msg,'type'=>'SMS Reply','name'=>$name,'smsno'=>$number));
	}
	
	public function smsAction($number,$array, $mun){
		$ticket_id = trim($array[0]);
		$msg = trim($array[1]);
		$name = $this->sms->getNameFromNumber($number);
		
		if(!$ticket_id || !$msg){
			if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
				$text = "Mali ang format na iyong ginamit. I-text ang TINGOG ACTION <report#>/<message>. Ex. TINGOG ACTION 1234/salamat! P1/txt.";
			}
			else{
				$text = "Sorry, mali ang format na iyong ginamit. Para magbigay ulat tungkol sa isang report, i-text ang TINGOG ACTION <report#><report code>/<message>. Ex. TINGOG ACTION TAB12345/ salamat! Para sa listahan ng iba pang keywords, text TINGOG HELP. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
			}
			$this->sms->sendSMS($number,$text);
			return false;
		}
		else{
			$ticket_id = preg_replace("/[^0-9]/iUs","", $ticket_id);
			$ticket = std2arr($this->citymodel->getTicketDetails($ticket_id));
			if(!isset($ticket[0])){
				if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
					$text = "Sorry, mali ang report number. Para magbigay ulat tungkol sa isang report, i-text ang TINGOG ACTION <report#>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt.";
				}
				else{
					$text = "Sorry, mali ang report number. I-check ang report number na iyong nais bigyan ng ulat. Para magbigay ulat tungkol sa isang report, i-text ang TINGOG ACTION <report#><report code>/<message>. Ex. TINGOG ACTION TAB12345/ salamat! P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free";
				}
				$this->sms->sendSMS($number,$text);
				return false;
			}
			else{
				if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
					$text = "Salamat sa iyong pagresponde. Ipaaalam namin agad ang resulta ng estado ng report na naiulat.Para sa listahan ng keywords,i-text ang TINGOG HELP sa 2015. P1/txt";
				}
				else{
					$text = "Salamat sa iyong pagresponde. Ipaaalam namin agad ang resulta ng estado ng report na naiulat. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
				}
				$this->sms->sendSMS($number,$text);
			}
		}
		$this->admin->ticketWriteMsgFromSMS(array('tid'=>$ticket_id,'msg'=>$msg,'type'=>'SMS Action','name'=>$name,'smsno'=>$number));
	}
	
	function simplifyText($str){
		$str = preg_replace("/\s+/i", " ", $str);
		$str = trim($str);
		return $str;
	}

	function createTicket($type='email'){
			if(isset($_GET['SUB_Mobtel']) && isset($_GET['SMS_Message_String']) && isset($_GET['CSP_Txid'])){
				$number = trim($_GET['SUB_Mobtel']);
				$sms = trim($_GET['SMS_Message_String']);
				$smstemp = strtolower($sms);
				$this->sms->recordTicket($number, urldecode($sms), $_GET['CSP_Txid']);
			}
			
			if($_GET['smstest']){
				$number = trim($_GET['SUB_Mobtel']);
				$sms = trim($_GET['smstest']);
				$smstemp = strtolower($sms);
				//pre($_SERVER);
				//exit();	
			
			}

			$smstemp = trim(strtolower($sms));
			$smstemp = preg_replace("/\s+/i", " ", $smstemp);

			if($type=='sms'){
				//echo "sadad";
			
				$tingog_url = "http://www.tingog.ph/";
				
				//phone send report message. "tab" is for tabacco
				/*
				TINGOG <LOCATION> /<barangay> /<report>
				*/
				$municipality = explode(".", $_SERVER['HTTP_HOST']); //lower case
				$municipality  = trim($municipality[0]);
				$municipality = strtolower($municipality);
				if(strpos($smstemp, "tingog ".$municipality)!==false){
					
					$strtemp = $this->simplifyText($sms);
					$strtemp = explode("/", $strtemp);
					
					$firstpo = explode(" ", trim($strtemp[0]));
					
					//print_r($firstpo);
					//exit();
					//if syntax: tingog tab basud/message
					$desc = $strtemp[1];

					$ting = $firstpo[0];
					$muni = $firstpo[1];
					$bara = $firstpo[2];

					//if syntax: tingog tab/basud/message
					if(!trim($bara)){
						$smsarr = explode("/", $sms);
						$bara = $smsarr[1];
						$desc = $smsarr[2];
					}
					else if(!trim($desc)){
						$desc = $bara;
						$bara = "-";
					}
					

					
					if(!trim($bara)||!trim($desc)){
						if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
							$rep = "Mali ang format na iyong ginamit.I-text ang TINGOG <LOCATION> <barangay> <report >. Ex. TINGOG TAB basud/ maganda ang inyong serbisyo. Ipadala sa 2015";
						}
						else{	
							$rep = "Sorry, mali ang format na iyong ginamit. 

Para magpadala ng report, i-text ang TINGOG <LOCATION>/<barangay>/<report >. Ex. TINGOG TAB basud/ maganda ang inyong serbisyo. Ipadala sa 2015. P1/txt";
						}
						$this->sms->sendSMS($number, $rep);
					}
					else{
						//get name from registered number
						$name = $this->sms->getNameFromNumber($number);
						$array['name'] = $name;
						$array['description'] = trim($desc);
						$array['number'] = $number;
						$array['location'] = trim($bara);
						$array['source'] = 'SMS';
						$ticketno = $this->admin->addTicket($array);
						//$ticketno = $municipality.substr("000000".$ticketno, -6);
						$ticketno = $municipality.$ticketno;
						//$rep = "Salamat sa iyong report. Ito ay ipaparating sa kinauukulan para sa kanilang aksyon. Tandaan ang iyong report number ".$ticketno.". Makakatanggap ka pa ng mga mensahe tungkol sa iyong report. Maaari ding alamin ang updates sa iyong report sa website ng TINGOG 2015 ".$tingog_url;
						
						if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
							$rep = "Salamat sa pag-report sa TINGOG 2015. Ito ay bibigyan pansin ng kinauukulan para sa tamang aksyon. Tandaan ang iyong report number ".$ticketno."";
						}
						else{
							$rep = "Salamat sa iyong report. Ito ay ipaparating sa kinauukulan para sa kanilang aksyon. Tandaan ang iyong report number ".$ticketno.". P1/txt.";
						}
						$this->sms->sendSMS($number, $rep);
					}
				}

				//tingog reg
				/*
				TINGOG REG
				*/
				else if(strpos($smstemp, "tingog reg")!==false){
					$sms = substr($sms, strlen("tingog reg"));
					$smsarr = explode("/", $sms);
					$mun = strtolower(trim($smsarr[0]));
					if($mun==$municipality){
						if(!trim($smsarr[1]) || !trim($smsarr[2]) || !trim($smsarr[3]) || !trim($smsarr[4])){
							if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
								$rep = "Maling format. Para mag-register, i-text ang TINGOG REG <LOCATION>/<barangay>/<name>/<age>/<gender>. Ex. TINGOG REG ADS/mapaga/jennycruz/30/F sa 2015. P1/txt";
							}
							else{
								$rep = "Sorry, mali ang format na iyong ginamit sa pag-register. I-text ang TINGOG REG <LOCATION>/<username>/<barangay>/<age>/<gender> Ex. TINGOG REG ADS/mscruz/mapaga/30/F sa 2015. P1/txt.
	
Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
							}
							$this->sms->sendSMS($number, $rep);
						}else{
							$check = $this->sms->checkUser($number);
							if($check){
								if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
									$rep = "Ikaw ay naka-register na. Para magpadala ng report, reply TINGOG <LOCATION> <barangay> <report> Ex. TINGOG TAB Cormidal Walang tao sa health center.";
								}
								else{
									$rep = "Hi! Ikaw ay naka-register na sa TINGOG 2015. Para makapagpadala ng report, i-txt ang TINGOG <LOCATION>/<barangay>/<report> Ex. TINGOG ADS/mscruz/walang tao sa health center at i-send sa 2015. P1/txt.
	
Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
								}
								$this->sms->sendSMS($number, $rep);
							}else{
								$this->sms->createUser($number, $smsarr[1],$smsarr[2],$smsarr[3],$smsarr[4]);
								if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
									$rep = "Salamat sa pag-register sa Tingog. Ang pagbibigay mo ng iyong impormasyon ay makatutulong upang mas mapabuti ang aming serbisyo.";
								}
								else{
									$rep = "Maraming salamat sa pag-register sa Tingog. Ang pagbibigay mo ng iyong impormasyon ay makakatulong upang mas mapabuti ang aming serbisyo. P1/txt.
	
Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
								}
								$this->sms->sendSMS($number, $rep);
							}
						}
					}
					else if($mun){
						if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
							$rep = "Invalid location.Locations:
TAB-Tabaco,
ADS-Agusan del Sur.Reply TINGOG REG <LOCATION>/<name>/<barangay>/<age>/<gender> Ex.TINGOG REG ADS/mscruz/mapaga/30/F";
						}
						else{
							$rep = "Sorry, mali ang format na iyong ginamit sa pag-register. I-text ang TINGOG REG <LOCATION>/<username>/<barangay>/<age>/<gender> Ex. TINGOG REG ADS/mscruz/mapaga/30/F sa 2015. P1/txt.
	
Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
						}
						$this->sms->sendSMS($number, $rep);
					}
					else{
						if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
							$rep = "Para mag-register sa Tingog 2015, i-text ang TINGOG REG <LOCATION>/<barangay>/<name>/<age>/<gender>. Ex. TINGOG REG ADS/mapaga/mscruz/30/F sa 2015. P1/txt";
						}
						else{
							$rep = "Sorry, mali ang format na iyong ginamit sa pag-register. I-text ang TINGOG REG <LOCATION>/<username>/<barangay>/<age>/<gender> Ex. TINGOG REG ADS/mscruz/mapaga/30/F sa 2015. P1/txt.
	
Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
						}
						$this->sms->sendSMS($number, $rep);
					}
				}
				//TINGOG REP 
				/*
				TINGOG REP 
				*/
				else if(strpos($smstemp, "tingog rep")!==false){
					$sms = trim($sms);
					$sms = substr($sms,10);
					$smsarr = explode("/", $sms);
					//$smsarr[0] is the ticket id and it might be prefixed by ads or tab...

					$ticketno = trim($smsarr[0]);
					$message = trim($smsarr[1]);

					$mun = preg_replace("/[0-9]/iUs", "", $smsarr[0]);
					$mun = strtolower(trim($mun));
					if($mun==$municipality){
						$this->smsReply($number,$smsarr, $municipality);
					}
					else if($ticketno==""){
						if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
							$text = "Para mag-reply sa Tingog, reply TINGOG REP <report#>/<message>.Ex. TINGOG REP 12345/salamat! P1/txt 

Para sa updates ng iyong report i-check sa www.tingog.ph";
						}
						else{
							$text = "Para mag-reply sa Tingog, reply TINGOG REP <report#>/<message>.Ex. TINGOG REP 12345/salamat! P1/txt 

Para sa updates ng iyong report i-check sa www.tingog.ph";
						}
						$this->sms->sendSMS($number,$text);
					}
					else{
						if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
							$text = "Sorry, mali ang report number. I-check ang report number. Para mag-reply, i-text ang TINGOG REP<report#>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt";
						}
						else{
							$text = "Sorry, mali ang report number. I-check ang report number na ibinigay sa iyo.  Para mag-reply, i-text ang TINGOG REP <report#><report code>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt.
		
Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
						}
						$this->sms->sendSMS($number,$text);
					}
				}
				
				//TINGOG ACTION 
				/*
				TINGOG ACTION
				*/
				else if(strpos($smstemp, "tingog action")!==false){
					$sms = trim($sms);
					$sms = substr($sms,13);
					$smsarr = explode("/", $sms);
					//$smsarr[0] is the ticket id and it might be prefixed by ads or tab...

					$ticketno = trim($smsarr[0]);
					$message = trim($smsarr[1]);

					
					$mun = preg_replace("/[0-9]/iUs", "", $smsarr[0]);
					$mun = strtolower(trim($mun));
					if($mun==$municipality){
						$this->smsAction($number,$smsarr, $municipality);
					}
					else if($ticketno==""){
						if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
							$text = "Para rumesponde sa ulat na natanggap, reply TINGOG ACTION <report #>/<message>. Ex. TINGOG ACTION 1234/Ito po ay natugunan na.";
						}
						else{
							$text = "Para rumesponde sa ulat na natanggap, reply TINGOG ACTION <report #>/<message>. Ex. TINGOG ACTION 1234/Ito po ay natugunan na.";
						}
						$this->sms->sendSMS($number,$text);
					}
					else{
						if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
							$text = "Sorry, mali ang report number. Para magbigay ulat tungkol sa isang report, i-text ang TINGOG ACTION <report#>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt.";
						}
						else{
							$text = "Sorry, mali ang report number. I-check ang report number na iyong nais bigyan ng ulat. Para magbigay ulat tungkol sa isang report, i-text ang TINGOG ACTION <report#><report code>/<message>. Ex. TINGOG ACTION TAB12345/ salamat! P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free";
						}
						$this->sms->sendSMS($number,$text);
					}
				}
				
				
				//tingog info
				/*
				TINGOG INFO
				*/
				else if(strpos($smstemp, "tingog info")!==false){
					if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
						$rep = "Keywords:
TINGOG REG-paano mag register
TINGOG <LOCATION> <barangay> <report>-para mag report 
TINGOG REP-paano mag-reply
I-text ang keyword sa 2015. P1/txt";
					}
					else{
						$rep = "Welcome sa TINGOG 2015! Ipadinig ang boses sa kinauukulan!
List of keywords:
TINGOG REG <LOCATION>/<username>/<barangay>/
<age>/ <gender> - para makapag-register
TINGOG <LOCATION>/<barangay>/<report>- para magpadala ng report. 
TINGOG REP <report#><report code>/<message>-para mag-reply o mag follow-up sa report
TINGOG LOCATION -  para sa listahan ng mga lokasyon

I-text <keyword> at i-send sa 2015. P1/txt.";
					}
					$this->sms->sendSMS($number, $rep);
				}
				//tingog help
				/*
				TINGOG HELP
				*/
				else if(strpos($smstemp, "tingog help")!==false){
					if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
						$rep = "TINGOG REG-paano mag register
TINGOG <LOCATION> <barangay> <report>-para mag report 
TINGOG REP-paano mag-reply
I-text ang keyword sa 2015. P1/txt";
					}
					else{
						$rep = "Welcome sa TINGOG 2015! Ipadinig ang boses sa kinauukulan!
List of keywords:
TINGOG REG <LOCATION>/<username>/<barangay>/
<age>/ <gender> - para makapag-register
TINGOG <LOCATION>/<barangay>/<report>- para magpadala ng report. 
TINGOG REP <report#><report code>/<message>-para mag-reply o mag follow-up sa report
TINGOG LOCATION -  para sa listahan ng mga lokasyon

I-text <keyword> at i-send sa 2015. P1/txt.";
					}
					$this->sms->sendSMS($number, $rep);
				}
				//tingog location
				/*
				TINGOG LOCATION
				*/
				else if(strpos($smstemp, "tingog location")!==false){
					if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
						$rep = "Tingog Locations:TAB-Tabaco, ADS-Agusan del Sur.Para magpadala ng report, reply TINGOG <LOCATION> <barangay> <report> Ex.TINGOG TAB basud galing niyo!";
					}
					else{
						$rep = "Ito ang mga kasaling Tingog Locations. TAB - Tabaco, ADS - Agusan del Sur. Para magpadala ng report, txt TINGOG <LOCATION>/<barangay>/<report >. Ex. TINGOG TAB/basud/ maganda ang inyong serbisyo. Para sa listahan ng iba pang keywords, text TINGOG HELP. P1/txt";
					}
					$this->sms->sendSMS($number, $rep);
				}
				//tingog on
				/*
				TINGOG ON
				*/
				else if(strpos($smstemp, "tingog on")!==false){
					$rep = "Hello! Ikaw ay naka-subscribe sa TINGOG 2015. Kung nais mag-unsubscribe, i-text ang TINGOG OFF sa 2015 for free. Para sa ibang keywords i-text ang TINGOG HELP. P1/txt

Para sa iba pang impormasyon, mag-log on sa website ng TINGOG 2015 ".$tingog_url;
					$this->sms->sendSMS($number, $rep);
				}
				//tingog off
				/*
				TINGOG OFF
				*/
				else if(strpos($smstemp, "tingog off")!==false){
					$rep = "Hello! Ikaw ay hindi naka-subscribe sa TINGOG 2015. Kung nais mong mag-subscribe at makatanggap ng mga advisory, announcement at balita i-text ang TINGOG ON sa 2015 for free. Para sa ibang keywords i-text ang TINGOG HELP. P1/txt

Para sa iba pang impormasyon, mag-log on sa website ng TINGOG 2015 ".$tingog_url;
					$this->sms->sendSMS($number, $rep);
				}
				
				//tingog
				/*
				TINGOG
				*/
				else if(trim($smstemp)=="tingog"){
					if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
						$rep = "Keywords:
TINGOG REG-paano mag register
TINGOG <LOCATION> <barangay> <report>-para mag report 
TINGOG REP-paano mag-reply
I-text ang keyword sa 2015. P1/txt";
					}
					else{
						$rep = "Welcome sa TINGOG 2015! Ipadinig ang boses sa kinauukulan!
List of keywords:
TINGOG REG <LOCATION>/<username>/<barangay>/
<age>/ <gender> - para makapag-register
TINGOG <LOCATION>/<barangay>/<report>- para magpadala ng report. 
TINGOG REP <report#><report code>/<message>-para mag-reply o mag follow-up sa report
TINGOG LOCATION - para sa listahan ng mga lokasyon

I-text <keyword> at i-send sa 2015. P1/txt.
";
					}
					$this->sms->sendSMS($number, $rep);
				}
				//mysubs
				/*
				MYSUBS
				*/
				else if(strpos($smstemp, "mysubs")!==false){
					$rep = "You are currently subscribed to the ff 2015 services:
TINGOG
To unsubscribe from a service, text <service name> OFF Ex.TINGOG OFF.";
					$this->sms->sendSMS($number, $rep);
				}
				else{
					if(1 || trim($_GET['telco'])=='smart'||trim($_GET['telco'])=='globe'){
						$rep = "Invalid location.Locations:
TAB-Tabaco,
ADS-Agusan del Sur.Reply TINGOG <LOCATION> <barangay> <report> Ex.TINGOG ADS Basud walang tubig. Send to 2015.P1/txt";
					}
					else{
						$rep = "Sorry, invalid location. Ito ang mga valid Tingog Locations:

TAB - Tabaco,
ADS - Agusan del Sur.

Para magpadala ng report, i-text ang TINGOG <LOCATION> <barangay>/<report>. Ex. TINGOG TAB basud/ walang tao sa opisina. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
					}
					$this->sms->sendSMS($number, $rep);
				}
				//pre(htmlentities($rep));
			}
			else{
			
				$array['name'] = $_POST['user_name'];
				$array['description'] = $_POST['description'];
				$array['email'] = $_POST['email'];
				$array['number'] = $_POST['contactnumber'];
				$array['location'] = $_POST['location'];
				$array['source'] = $type;
				$this->admin->addTicket($array);
				echo "Thank you for submitting your report.";
			}
			
			if($_GET['tester']){
				?><form action='http://<?php echo $municipality; ?>.tingog.ph/backend/admin/createticket/sms/'>
					<input type='hidden' name='tester' value=1 />

					<center>
					Mobile Number<br>e.g. (639228772727)<br><input type='text' name='SUB_Mobtel' value="<?php echo htmlentities($_GET['SUB_Mobtel'])?>" /> <br>
					Telco<br><select name='telco' id='telco'>
						<option value='sun'>Sun</option>
						<option value='smart'>Smart</option>
						<option value='globe'>Globe</option>
					</select><br>
					<script>
						document.getElementById("telco").value = "<?php echo htmlentities($_GET['telco']); ?>";
					</script>
					Message <br> <textarea name='smstest' style='width:400px; height:300px'><?php echo htmlentities($_GET['smstest'])?></textarea><br>
				  	No SMS? <input type='checkbox' name='nosms' value=1 checked="checked" /><br>
					<input type='submit' value='Send'>
				  </form>
				<?php
			}
			#pre($_POST);
		#}else{
		#	$content['content'] = returnNoAccessRight();
		#}
	}
	
	
	
}
?>