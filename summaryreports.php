<?
	include("tab/backend/application/helpers/functions_helper.php");
	include('includes/Snoopy.class.php');
	
	$snoopy = new Snoopy();
	
	if($_REQUEST['Submit']){
		$snoopy->submit("http://tab.tingog.ph/backend/report/ticketWs", $_POST);
		#$snoopy->submit("http://127.0.0.1:8081/backend/report/ticketWs", $_POST);
	}else{
		$snoopy->submit("http://tab.tingog.ph/backend/report/ticketWs");
		#$snoopy->submit("http://127.0.0.1:8081/backend/report/ticketWs");
	}
	
	$contents = $snoopy->results;
	$contents = (json_decode($contents));
	$r = std2arr($contents[0]);
  	#pre("Hello: ".$r['average_response']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once(dirname(__FILE__)."/includes/head_script.php"); ?>
<link rel="stylesheet" type="text/css" href="styles/styles_1.css" />
<script src="javascripts/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" src="tab/backend/javascript/jquery.js"></script>
<script type="text/javascript" src="tab/backend/javascript/jsapi.js"></script>
<script>
	google.load("visualization", "1", {packages:["corechart"]});
</script>
<script src="tab/backend/javascript/datepicker/jquery.ui.core.js"></script>
<script src="tab/backend/javascript/datepicker/jquery.ui.widget.js"></script>
<script type="text/javascript" src="tab/backend/javascript/datepicker/jquery.ui.datepicker.js"></script>
<script>
$(function() {
	$( "#datepicker_from" ).datepicker();
});

$(function() {
	$( "#datepicker_to" ).datepicker();
});

function filterSubmit(){
	jQuery.ajax({
		type: 'POST',
		url: "tab/report/filter",
		data: jQuery("#form1").serialize(),
		success: function(message){
			jQuery("#message").html(message);
		},
	});
}
</script>
</head>

<body>
<div id="outer">
	<?php include_once(dirname(__FILE__)."/includes/header.php"); ?>
    <div id="site_content_1">
    	<table width="900" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="padding-bottom:20px;"><a href="index.php" class="link_4"><b>&laquo; back to tabaco main page</b></a></td>
          </tr>
          <tr>
            <td class="text_1" style="padding-bottom:25px;"><form name="form1" method="post" action="" id="form1">
              <p class="text_1">Location:
                <select name="location" id="location" class="input_1" style="width:150px;" onchange="window.location.href=this.options
        [this.selectedIndex].value;">
                    <option value="">--</option>
                    <option value="http://ads.tingog.ph/summaryreports.php">Agusan Del Sur</option>
                	<option value="http://tab.tingog.ph/summaryreports.php">Tabaco</option>
                </select>
                &nbsp;&nbsp; Department:
                <select name="department" id="department" class="input_1" style="width:150px;">
                    <option value="">--</option>
                    <?
	  	foreach($r['departments'] as $k => $v){
			echo "<option value=\"".$v['id']."\" ";
			if(isset($_POST['department']) && $_POST['department']==$v['id']) echo "selected";
			echo ">".$v['department']."</option>";
		}
	  ?>
                </select>
                &nbsp;&nbsp; Category:
                <select name="category" id="category" class="input_1" style="width:150px;">
                  <option value="">--</option>
                  <?
	  	foreach($r['categories'] as $k => $v){
			echo "<option value=\"".$v['id']."\" ";
			if(isset($_POST['category']) && $_POST['category']==$v['id']) echo "selected";
			echo ">".$v['category']."</option>";
		}
	  ?>
                </select>
                &nbsp;&nbsp; Issue:
                <select name="issue" id="issue" class="input_1" style="width:150px;">
                  <option value="">--</option>
                  <?
	  	foreach($r['issues'] as $k => $v){
			echo "<option value=\"".$v['id']."\" ";
			if(isset($_POST['issue']) && $_POST['issue']==$v['id']) echo "selected";
			echo ">".$v['issue']."</option>";
		}
	  ?>
                </select>
                &nbsp;&nbsp; 
              </p>
              <p>&nbsp;</p>
              <?
  	if(isset($_POST['datepicker_from'])) $datepicker_from = $_POST['datepicker_from'];
	else $datepicker_from = "";
	
  	if(isset($_POST['datepicker_to'])) $datepicker_to = $_POST['datepicker_to'];
	else $datepicker_to = "";
  ?>
              <p class="text_1">Barangay:
                <select name="location" id="location" class="input_1" style="width:150px;">
                  <option value="">--</option>
                  <?
	  	foreach($r['locations'] as $k => $v){
			echo "<option value=\"".$v['id']."\" ";
			if(isset($_POST['location']) && $_POST['location']==$v['id']) echo "selected";
			echo ">".$v['name']."</option>";
		}
	  ?>
                </select> &nbsp;&nbsp; Range:
                <input name="datepicker_from" type="text" id="datepicker_from" class="input_1" style="width:150px;" value="<? echo $datepicker_from; ?>" />
                -
                <input name="datepicker_to" type="text" id="datepicker_to" class="input_1" style="width:150px;" value="<? echo $datepicker_to; ?>" />
              </p>
              <p>&nbsp;</p>
              <p>
                <input type="submit" name="Submit" value="Submit" class="btn_2" style="width:100px;" />
              </p>
            </form></td>
          </tr>
        </table>
        <fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Status Report(s)&nbsp;&nbsp;</b></legend>
        <table width="750" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="375" valign="top" style="border-right:1px dotted #666;">
                <table width="375" border="0" cellspacing="0" cellpadding="0">
                  <!-- TOTAL NUMBER OF TICKETS -->
                  <tr>
                    <td class="text_1" width="300"><b>Total number of ticket(s) received</b></td>
                    <td class="text_1" width="75"><b>:</b> <? echo array_sum($r['status']); ?></td>
                  </tr>
                  <tr>
                    <td class="text_1" colspan="2">&nbsp;</td>
                  </tr>
				  <?
				  if(is_array($r['status'])){
				  	foreach($r['status'] as $k=>$v){
				  ?>
                  <tr>
                    <td class="text_3" style="text-indent:50px;"><b><? echo ucwords($k); ?></b></td>
                    <td class="text_3"><b>:</b> <? echo $v; ?></td>
                  </tr>
				  <?
				  		#pre($r['closed']);
						if($k=='closed'){
							foreach(array_tag() as $kk=>$vv){
								#if($kk){
				  ?>
                  <tr>
                    <td class="text_1" style="text-indent:70px;"><b>- <? echo ucwords($vv); ?></b></td>
                    <td class="text_1"><b>:</b> <? if($r['closed'][$kk]) echo $r['closed'][$kk]; else echo 0; ?></td>
                  </tr>
				  <?
				  				#}
							}
						}
						
						if($k=='parked'){
							foreach(array_parked() as $kk=>$vv){
								#if($kk){
				  ?>
                  <tr>
                    <td class="text_1" style="text-indent:70px;"><b>- <? echo ucwords($vv); ?></b></td>
                    <td class="text_1"><b>:</b> <? if($r['parked'][$kk]) echo $r['parked'][$kk]; else echo 0; ?></td>
                  </tr>
				  <?
				  				#}
							}
						}
						#pre($r['average_response']);
						if($k=='resolved' && isset($r['average_response'])){
				  ?>
                  <tr>
                    <td class="text_1" style="text-indent:70px;"><b>- Avg Response Time</b></td>
                    <td class="text_1"><b>:</b> <? echo $r['average_response'].' day(s)'; ?></td>
                  </tr>
				  <?
				  		}
				  ?>
                  <tr>
                    <td class="text_1" colspan="2">&nbsp;</td>
                  </tr>
				  <?
				  	}
				}
					
					$status = $r['status'];
				  ?>
                  <!-- END OF TOTAL NUMBER OF TICKETS -->
                </table>            </td>
            <td width="459" valign="top" style="padding-left:20px;"><div style="float:left; width:450px; height:auto;">
	<div id="chart"></div>
	<script type="text/javascript">
    //google.load("visualization", "1", {packages:["corechart"]});
    
    //google.setOnLoadCallback(drawChart1);
    function drawChart1() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Task');
    data.addColumn('number', 'Total Reports');
    data.addRows([
        ['New',<?php echo $status['new']; ?>],
        ['Dispatched',<?php echo $status['dispatched']; ?>],
        ['Returned',<?php echo $status['returned']; ?>],
        ['Assigned',<?php echo $status['assigned']; ?>],
        ['Resolved',<?php echo $status['resolved']; ?>],
        ['Parked',<?php echo $status['parked']; ?>],
        ['Closed',<?php echo $status['closed']; ?>]
    ]);
    
    var options = {
        title: ''
    };
    
    var chart = new google.visualization.PieChart(document.getElementById('chart'));
    chart.draw(data, options);
    }
    drawChart1(); 
    </script>
</div></td>
          </tr>
          <tr>
            <td style="border-bottom:1px dotted #666;" colspan="2">&nbsp;</td>
          </tr>
        </table>
        </fieldset>
        <div>&nbsp;</div>
        <fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Actual Report(s) Per Barangay &nbsp;&nbsp;</b></legend>
        <p><script type="text/javascript">
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Barangay');
        data.addColumn('number', 'Received');
        data.addColumn('number', 'Resolved');
        data.addRows([
          <?
		  	$i=0;
		  	foreach($r['locations'] as $k => $v){
				$count = isset($r['chart']['barangays'][$v['id']]['count']) ? $r['chart']['barangays'][$v['id']]['count'] : 0;
				$resolved = isset($r['chart']['barangays'][$v['id']]['resolved']) ? $r['chart']['barangays'][$v['id']]['resolved'] : 0;
				echo "['".$v['name']."', ".$count.", ".$resolved."]";
				if(count($r['locations'])>$i) echo ",";
				$i++;
			}
		  ?>
        ]);

        var options = {
          //title: 'Reports Per Barangay',
          vAxis: {title: 'Barangays',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
</p>
  <div id="chart_div" style="width: 800px; height: 400px;"></div>
        </fieldset>
		
		
		<div>&nbsp;</div>
        <fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Most Common Categories&nbsp;&nbsp;</b></legend>
		<table width="750" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="375" valign="top" style="border-right:1px dotted #666;"><table width="375" border="0" cellspacing="0" cellpadding="0">
                <!-- TOTAL NUMBER OF TICKETS -->

                <tr>
                  <td class="text_1" colspan="2">&nbsp;</td>
                </tr>
                <?
				  	foreach($r['categories'] as $k=>$v){
						$count = isset($r['chart']['categories'][$v['id']]) ? $r['chart']['categories'][$v['id']] : 0;
				  ?>
                <tr>
                  <td width="300" class="text_3" style="text-indent:50px;"><b><? echo ucwords($v['category']); ?></b></td>
                  <td width="75" class="text_3"><b>:</b> <? echo $count; ?></td>
                </tr>
                <tr>
                  <td class="text_1" colspan="2">&nbsp;</td>
                </tr>
                <?
				  	}
					
				  ?>
            </table></td>
            <td width="459" valign="top" style="padding-left:20px;"><div style="float:left; width:450px; height:auto;">
                <div id="categories"></div>
                <script type="text/javascript">
		function categories() {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Task');
			data.addColumn('number', 'Total Reports');
			data.addRows([
			<?
				$i = 0;
				foreach($r['categories'] as $k=>$v){
					$count = isset($r['chart']['categories'][$v['id']]) ? $r['chart']['categories'][$v['id']] : 0;
					echo "['".$v['category']."',".$count."]";
					if(count($r['categories'])>$i) echo ',';
					$i++;
				}
			?>
			]);
			
			var options = {
				title: ''
			};
			
			var chart = new google.visualization.PieChart(document.getElementById('categories'));
			chart.draw(data, options);
		}
		categories(); 
		</script>
            </div></td>
          </tr>
          <tr>
            <td style="border-bottom:1px dotted #666;" colspan="2">&nbsp;</td>
          </tr>
        </table>
		</fieldset>
		
		<div>&nbsp;</div>
		<fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Most Common Issues &nbsp;&nbsp;</b></legend>
        <table width="750" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="375" valign="top" style="border-right:1px dotted #666;">
                <table width="375" border="0" cellspacing="0" cellpadding="0">
                  <!-- TOTAL NUMBER OF TICKETS -->
                  <tr>
                    <td class="text_1" colspan="2">&nbsp;</td>
                  </tr>
				  <?
				  	foreach($r['issues'] as $k=>$v){
						$count = isset($r['chart']['issues'][$v['id']]) ? $r['chart']['issues'][$v['id']] : 0;
				  ?>
                  <tr>
                    <td width="300" class="text_3" style="text-indent:50px;"><b><? echo ucwords($v['issue']); ?></b></td>
                    <td width="75" class="text_3"><b>:</b> <? echo $count; ?></td>
                  </tr>
                  <tr>
                    <td class="text_1" colspan="2">&nbsp;</td>
                  </tr>
				  <?
				  	}
					
					$status = $r['status'];
				  ?>
                  <!-- END OF TOTAL NUMBER OF TICKETS -->
                </table>            </td>
            <td width="459" valign="top" style="padding-left:20px;"><div style="float:left; width:450px; height:auto;">
	<div id="issues"></div>
	<script type="text/javascript">
		function issues() {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Task');
			data.addColumn('number', 'Total Reports');
			data.addRows([
			<?
				$i = 0;
				foreach($r['issues'] as $k=>$v){
					$count = isset($r['chart']['issues'][$v['id']]) ? $r['chart']['issues'][$v['id']] : 0;
					echo "['".$v['issue']."',".$count."]";
					if(count($r['issues'])>$i) echo ',';
					$i++;
				}
			?>
			]);
			
			var options = {
				title: ''
			};
			
			var chart = new google.visualization.PieChart(document.getElementById('issues'));
			chart.draw(data, options);
		}
		issues(); 
    </script>
</div></td>
          </tr>
          <tr>
            <td style="border-bottom:1px dotted #666;" colspan="2">&nbsp;</td>
          </tr>
        </table>
        </fieldset>
		
		<div>&nbsp;</div>
		<fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Share of reports among concerned offices&nbsp;&nbsp;</b></legend>
        <table width="750" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="375" valign="top" style="border-right:1px dotted #666;">
                <table width="375" border="0" cellspacing="0" cellpadding="0">
                  <!-- TOTAL NUMBER OF TICKETS -->
                  <tr>
                    <td class="text_1" colspan="2">&nbsp;</td>
                  </tr>
				  <?
				  	foreach($r['departments'] as $k=>$v){
						$count = isset($r['chart']['department'][$v['id']]) ? $r['chart']['department'][$v['id']] : 0;
				  ?>
                  <tr>
                    <td width="300" class="text_3" style="text-indent:50px;"><b><? echo ucwords($v['department']); ?></b></td>
                    <td width="75" class="text_3"><b>:</b> <? echo $count; ?></td>
                  </tr>
                  <tr>
                    <td class="text_1" colspan="2">&nbsp;</td>
                  </tr>
				  <?
				  	}
					
					$status = $r['status'];
				  ?>
                  <!-- END OF TOTAL NUMBER OF TICKETS -->
                </table>            </td>
            <td width="459" valign="top" style="padding-left:20px;"><div style="float:left; width:450px; height:auto;">
	<div id="departmentsx"></div>
	<script type="text/javascript">
		function departments() {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Task');
			data.addColumn('number', 'Total Reports');
			data.addRows([
			<?
				$i = 0;
				foreach($r['departments'] as $k=>$v){
					$count = isset($r['chart']['department'][$v['id']]) ? $r['chart']['department'][$v['id']] : 0;
					echo "['".$v['department']."',".$count."]";
					if(count($r['departments'])>$i) echo ',';
					$i++;
				}
			?>
			]);
			
			var options = {
				title: ''
			};
			
			var chart = new google.visualization.PieChart(document.getElementById('departmentsx'));
			chart.draw(data, options);
		}
		departments(); 
    </script>
</div></td>
          </tr>
          <tr>
            <td style="border-bottom:1px dotted #666;" colspan="2">&nbsp;</td>
          </tr>
        </table>
        </fieldset>
        <div>&nbsp;</div>
<fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Reports among concerned offices&nbsp;&nbsp;</b></legend>
        <p><script type="text/javascript">
      google.setOnLoadCallback(unresolveOffice);
      function unresolveOffice(){
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Barangay');
        data.addColumn('number', 'Resolved');
        data.addColumn('number', 'Unresolve');
        data.addColumn('number', 'Dispatched');
        data.addColumn('number', 'Assigned');
        data.addRows([
          <?
		  	$i=1;
		  	foreach($r['departments'] as $k => $v){
				#pre($v);
				$count = isset($r['chart']['office'][$v['id']]['count']) ? $r['chart']['office'][$v['id']]['count'] : 0;
				$resolved = isset($r['chart']['office'][$v['id']]['resolved']) ? $r['chart']['office'][$v['id']]['resolved'] : 0;
				$unres = isset($r['chart']['office'][$v['id']]['unresolve']) ? $r['chart']['office'][$v['id']]['unresolve'] : 0;
				$dispatched = isset($r['chart']['office'][$v['id']]['dispatched']) ? $r['chart']['office'][$v['id']]['dispatched'] : 0;
				$assigned = isset($r['chart']['office'][$v['id']]['assigned']) ? $r['chart']['office'][$v['id']]['assigned'] : 0;
				
				echo "['".$v['department']."', ".$resolved.", ".$unres.", ".$dispatched.",".$assigned."]";
				if(count($r['departments'])>$i) echo ",";
				$i++;
			}
		  ?>
        ]);

        var options = {
          //title: 'Reports Per Barangay',
          vAxis: {title: 'Department Office',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('unresolveOffice'));
        chart.draw(data, options);
      }
    </script>
</p>
  <div id="unresolveOffice" style="width: 800px; height: 400px;"></div>
        </fieldset>
		<div>&nbsp;</div>
<fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Reports among barangays&nbsp;&nbsp;</b></legend>
        <p><script type="text/javascript">
      google.setOnLoadCallback(unresolveBrgy);
      function unresolveBrgy(){
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Barangay');
        data.addColumn('number', 'Resolved');
        data.addColumn('number', 'Unresolve');
        data.addColumn('number', 'Dispatched');
        data.addColumn('number', 'Assigned');
        data.addRows([
          <?
		  	$i=0;
		  	foreach($r['locations'] as $k => $v){
				$count = isset($r['chart']['barangays'][$v['id']]['count']) ? $r['chart']['barangays'][$v['id']]['count'] : 0;
				$resolved = isset($r['chart']['barangays'][$v['id']]['resolved']) ? $r['chart']['barangays'][$v['id']]['resolved'] : 0;
				$unres = isset($r['chart']['barangays'][$v['id']]['unresolve']) ? $r['chart']['barangays'][$v['id']]['unresolve'] : 0;
				$dispatched = isset($r['chart']['barangays'][$v['id']]['dispatched']) ? $r['chart']['barangays'][$v['id']]['dispatched'] : 0;
				$assigned = isset($r['chart']['barangays'][$v['id']]['assigned']) ? $r['chart']['barangays'][$v['id']]['assigned'] : 0;
				
				echo "['".$v['name']."', ".$resolved.", ".$unres.", ".$dispatched.",".$assigned."]";
				if(count($r['locations'])>$i) echo ",";
				$i++;
			}
		  ?>
        ]);

        var options = {
          //title: 'Reports Per Barangay',
          vAxis: {title: 'Barangays',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('unresolveBrgy'));
        chart.draw(data, options);
      }
    </script>
</p>
  <div id="unresolveBrgy" style="width: 800px; height: 400px;"></div>
      </fieldset>
		<div>&nbsp;</div>
        <fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Average Response Time Per Barangay &nbsp;&nbsp;</b></legend>
        <p><script type="text/javascript">
      google.setOnLoadCallback(drawChartART);
      function drawChartART() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Barangay');
        data.addColumn('number', 'Average Response Time');
        data.addRows([
          <?
		  	$i=0;
		  	foreach($r['locations'] as $k => $v){
				$count = isset($r['chart']['barangays'][$v['id']]['count']) ? $r['chart']['barangays'][$v['id']]['count'] : 0;
				//$resolved = isset($r['chart']['barangays'][$v['id']]['resolved']) ? $r['chart']['barangays'][$v['id']]['resolved'] : 0;
				$art = isset($r['chart']['barangays'][$v['id']]['response']) ? $r['chart']['barangays'][$v['id']]['response'] : 0;
				echo "['".$v['name']."', ".$art."]";
				if(count($r['locations'])>$i) echo ",";
				$i++;
			}
		  ?>
        ]);

        var options = {
          //title: 'Reports Per Barangay',
          vAxis: {title: 'Barangays',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chartART_div'));
        chart.draw(data, options);
      }
    </script>
</p>
  <div id="chartART_div" style="width: 800px; height: 400px;"></div>
        </fieldset>
		<div>&nbsp;</div>
    </div>
    <?php include_once(dirname(__FILE__)."/includes/footer.php"); ?>
</div>
</body>
</html>