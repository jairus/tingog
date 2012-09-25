<?php
	session_start();
	if(isset($_SESSION['user_id']) && isset($_SESSION['user_login'])){
		header("location: /backend");
		exit();
	}
	
	if($_REQUEST['btn_login']){
		define('BASEPATH',true);
		include('application/config/database.php');
		
		$link = mysql_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']) or die("Could not connect : " . mysql_error());
		mysql_select_db($db['default']['database'],$link);
		
		$result = mysql_query("SELECT * FROM users WHERE `user_login`='".$_REQUEST['input_user']."' AND `user_password`=MD5('".$_REQUEST['input_pass']."')");
		if(mysql_num_rows($result)){
			$r = mysql_fetch_assoc($result);
			#print_r($r);
			$_SESSION['user_id'] = $r['id'];
			$_SESSION['user_login'] = $r['user_login'];
			$_SESSION['department'] = $r['department'];
			#$_SESSION['']
			$get_access_name = mysql_query("SELECT * FROM access_level WHERE id='".$r['access_level']."'");
			if(mysql_num_rows($get_access_name)){
				$access = mysql_fetch_assoc($get_access_name);
				$_SESSION['access_level'] = strtolower($access['name']);
			}
			
			
			$_SESSION['access_levels'] = array('index');
			$get_access_level = mysql_query("SELECT * FROM access_level_option WHERE `access_level_id` = '".$r['access_level']."'");
			if(mysql_num_rows($get_access_level)){
				while($ar = mysql_fetch_assoc($get_access_level)){
					$_SESSION['access_levels'][$ar['class']][0] = 'index';
					$_SESSION['access_levels'][$ar['class']][] = $ar['function']; //array('class'=>,'function'=>$ar['function']);
				}
			}
			
			header("location: /backend");
			exit();
		}else{
			$msg = "Invalid username or password";
		}
		
		mysql_close($link);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Tingog 2015 - Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META name="keywords" content="Tingog 2015 - Login" />
<META name="description" content="Tingog 2015 - Login" />
<link rel="Shortcut Icon" href="images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="styles/styles_1.css" />
</head>

<body>
<div id="login_outer">
	<div id="login_content">
    	<div id="login_logo"><img src="images/main_logo.jpg" width="225" height="150" border="0" alt="Tingog 2015" title="Tingog 2015" /></div>
        <div class="login_loc">TABACO CITY</div>
        <div id="login_corners"><img src="images/header_corner_left01.png" width="10" height="10" border="0" /></div>
        <div id="login_top">&nbsp;</div>
        <div id="login_corners"><img src="images/header_corner_right01.png" width="10" height="10" border="0" /></div>
        <form id="form1" name="form1" method="post" action="">
		<div id="login_inside">
<?php 	
if($msg){ 
?>
        	<div id="login_inputs" class="msg_text_1" style="text-align:center;"><? echo $msg; ?></div>
<?php
}
?>
            
            <div id="login_inputs">
                <div id="login_text" class="text_2"><b>username</b></div>
                <div id="login_textbox"><input type="text" id="input_user_id" name="input_user" value="" class="input_1" style="width:250px;" /></div>
            </div>
            <div id="login_inputs">
                <div id="login_text" class="text_2"><b>password</b></div>
                <div id="login_textbox"><input type="password" id="input_pass_id" name="input_pass" value="" class="input_1" style="width:250px;" /></div>
            </div>
            <div id="login_inputs" style="text-align:center;"><input type="submit" id="btn_login_id" name="btn_login" class="btn_3" value="login" style="width:150px;" />
            </div>
        </div>
		</form>
        <div id="login_corners"><img src="images/footer_corner_left02.png" width="10" height="10" border="0" /></div>
        <div id="login_bottom">&nbsp;</div>
        <div id="login_corners"><img src="images/footer_corner_right02.png" width="10" height="10" border="0" /></div>
    </div>
</div>
</body>
</html>