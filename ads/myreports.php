<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once(dirname(__FILE__)."/includes/head_script.php"); ?>
<link rel="stylesheet" type="text/css" href="styles/styles_1.css" />
<script src="javascripts/SpryMenuBar.js" type="text/javascript"></script>
</head>

<body>
<div id="outer">
	<?php include_once(dirname(__FILE__)."/includes/header_agusandelsur.php"); ?>
    <div id="site_content_1">
    	<?php include_once(dirname(__FILE__)."/includes/left_sidebar_agusandelsur.php"); ?>
        <div id="right_content">
            <p class="text_6" style="padding:20px 0px;">Track Report</p>
            <div id="aboutus">
                <div id="maincontactus_box">
                    <div id="maincontactus_text" class="text_16">Report No:</div>
                    <div id="maincontactus_input"><input type="text" id="report_num_id" name="report_num" class="input_1" style="width:250px;" /></div>
                </div>
                <div id="maincontactus_box">
                    <div id="maincontactus_text" class="text_16">Mobile No:</div>
                    <div id="maincontactus_input"><input type="text" id="mobile_num_id" name="mobile_num" class="input_1" style="width:250px;" /></div>
                </div>
                <div id="maincontactus_box" style="text-align:right; padding-right:260px; width:473px;"><input type="button" id="btn_send_id" name="btn_send" value="Send" class="btn_2" style="width:100px;" /></div>
            </div>
        </div>
    </div>
    <?php include_once(dirname(__FILE__)."/includes/footer.php"); ?>
</div>
</body>
</html>