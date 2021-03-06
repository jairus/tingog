<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once(dirname(__FILE__)."/includes/head_script.php"); ?>
<link rel="stylesheet" type="text/css" href="styles/styles_1.css" />
<script src="javascripts/SpryMenuBar.js" type="text/javascript"></script>
</head>

<body>
<div id="outer">
	<?php include_once(dirname(__FILE__)."/includes/header.php"); ?>
    <div id="site_content_1">
    	<?php include_once(dirname(__FILE__)."/includes/left_sidebar.php"); ?>
        <div id="right_content">
            <p class="text_6" style="padding:20px 0px;">Submit a Report</p>
            <div id="aboutus">
                <div id="maincontactus_box">
                    <div id="maincontactus_text" class="text_16">Name (optional):</div>
                    <div id="maincontactus_input"><input type="text" id="user_name_id" name="user_name" class="input_1" style="width:250px;" /></div>
                </div>
                <div id="maincontactus_box">
                    <div id="maincontactus_text" class="text_16">Barangay:</div>
                    <div id="maincontactus_input"><input type="text" id="barangay_id" name="barangay" class="input_1" style="width:250px;" /></div>
                </div>
                <div id="maincontactus_box">
                    <div id="maincontactus_text" class="text_16">Mobile No.:</div>
                    <div id="maincontactus_input"><input type="text" id="mobile_num_id" name="mobile_num" class="input_1" style="width:250px;" /></div>
                </div>
                <div id="maincontactus_box">
                    <div id="maincontactus_text" class="text_16">Report:</div>
                    <div id="maincontactus_input"><textarea id="report_id" name="report" class="input_1" style="width:250px; height:100px;"></textarea></div>
                </div>
                <div id="maincontactus_box" style="text-align:right; padding-right:260px; width:473px;"><input type="button" id="btn_report_id" name="btn_report" value="Report" class="btn_2" style="width:100px;" /></div>
            </div>
        </div>
    </div>
    <?php include_once(dirname(__FILE__)."/includes/footer.php"); ?>
</div>
</body>
</html>