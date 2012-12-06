<?php
	function validate_nav($array,$class){
		$x = false;
		if($_SESSION['user_login']=='admin'){
			$x = true;
		}else{
			
			foreach($array as $function){
				#pre($function);
				if(isset($_SESSION['access_levels'][$class]) && is_array($_SESSION['access_levels'][$class])){
					if(in_array($function,$_SESSION['access_levels'][$class])){
						$x = true;
					}
				}
			}
		}
		return $x;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Tingog 2015 - User</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META name="keywords" content="Tingog 2015 - City Access" />
<META name="description" content="Tingog 2015 - City Access" />
<link rel="Shortcut Icon" href="/backend/images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="/backend/styles/styles_1.css" />
<link type="text/css" href="/backend/styles/jquery/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="/backend/javascript/jquery.js"></script>
<script type="text/javascript" src="/backend/javascript/jsapi.js"></script>
<script>
//jairus
google.load("visualization", "1", {packages:["corechart"]});
</script>
<!-- MENU BAR -->

<script type="text/javascript">
$(document).ready(function(){
	$("body div:last").remove();
});
</script>
<!-- END OF MENU BAR -->

<!-- TAB -->
<link type="text/css" href="/backend/styles/tab/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="/backend/javascript/tab/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/backend/javascript/dialogbox/jquery-ui-1.8.17.custom.min.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

	
<script type="text/javascript">
$(function(){
	$('#tabs').tabs();
	$('#dialog_link, ul#icons li').hover(
		function() { $(this).addClass('ui-state-hover'); }, 
		function() { $(this).removeClass('ui-state-hover'); }
	);
	
});
</script>
<style type="text/css">body{ font: 90% "Trebuchet MS", sans-serif;}</style>
<!-- END OF TAB -->

<script type="text/javascript">
//THREAD FORM
var centerWidthThread  = (window.screen.width - 643) / 2;
var centerHeightThread = (window.screen.height - 720) / 2;

function openThread() {window.open("thread.php",'thread','width=643px, height=720px, left='+centerWidthThread+', top='+centerHeightThread+', scrollbars=yes, status=yes')}
//END OF THREAD FORM
</script>
</head>

<body>
<div id="outer">
	<div id="site_content_1" >
    	<div id="menu">
            <ul class="menu">
			  <li><a href="/backend/report"><span>Full Report</span></a></li>
<?php
					if(isset($_SESSION['access_levels']['cityaccess'])){
						#$city = $_SESSION['access_levels']['cityaccess'];
						#if(validate_nav($city,'cityaccess')) echo '<li><a href="'.base_url().'cityaccess"><span>City Access</span></a></li>';
						echo '<li><a href="/backend/cityaccess"><span>City Access</span></a></li>';
					}
					
					if(isset($_SESSION['access_levels']['department'])){
						#$department = $_SESSION['access_levels']['department'];
						#if(validate_nav($department,'department')) echo '<li><a href="'.base_url().'department"><span>Department</span></a></li>';
						echo '<li><a href="/backend/department"><span>Concerned Office</span></a></li>';
					}
					
					if(isset($_SESSION['access_levels']['citizen'])){
						#$ngo = $_SESSION['access_levels']['department'];
						#if(validate_nav($ngo,'ngo')) echo '<li><a href="'.base_url().'ngo"><span>NGO</span></a></li>';
						echo '<li><a href="/backend/citizen"><span>Citizen Partner</span></a></li>';
					}
					
					if(isset($_SESSION['access_levels']['admin'])){
						#$admin = $_SESSION['access_levels']['admin'];
						#if(validate_nav($admin,'admin')){
						#	echo '<li><a href="#" class="parent"><span>System Admin</span></a>';
						#}
						echo '<li><a href="#" class="parent"><span>System Admin</span></a>';
					}
				?>
                    <ul>
                        <li><a href="/backend/admin/accounts"><span>User Accounts</span></a></li>
                        <li><a href="/backend/admin/access"><span>Access Level</span></a></li>
                        <li><a href="/backend/admin/departments"><span>Concerned Offices</span></a></li>
                        <li><a href="/backend/admin/categories"><span>Categories</span></a></li>
                        <li><a href="/backend/admin/issues"><span>Issues</span></a></li>
                        <li><a href="/backend/admin/personnel"><span>Personnel</span></a></li>
                        <li><a href="/backend/admin/barangay"><span>Barangay</span></a></li>
                    </ul>
				</li>
                <li class="last"><a href="/backend/logout.php"><span>Logout</span></a></li>
          </ul>
        </div>
    </div>
    <div id="site_content_2" class="text_3"><?php echo $page_title; ?></div>
    <div id="site_content_1"'>
<?php
	echo $content;
?>
    </div>
    <div id="site_content_1" style="text-align:center;" class="text_1">
    	<p>&nbsp;</p>
        <p>Copyright &copy; 2012 Tingog 2015. All rights reserved</p>
    </div>
</div>
</body>
</html>
<?php
#pre($_SESSION);
?>