<style>
.text_3 {
    color: #3D3D3D;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: normal;
}
</style>
 <fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Status Report(s)&nbsp;&nbsp;</b></legend>
        <table width="750" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="375" valign="top" style="border-right:1px dotted #666;">
                <table width="375" border="0" cellspacing="0" cellpadding="0">
                  <!-- TOTAL NUMBER OF TICKETS -->
                  <!--tr>
                    <td class="text_1" width="300"><b>Total number of ticket(s) received</b></td>
                    <td class="text_1" width="75"><b>:</b> <? echo array_sum($r['status']); ?></td>
                  </tr>
                  <tr>
                    <td class="text_1" colspan="2">&nbsp;</td>
                  </tr-->
				  <?
				  #pre($r['status']);
				  #if(is_array($r['status'])){
				  	#foreach($r['status'] as $k=>$v){
				  ?>
                  <tr>
                    <td class="text_3"><? echo array_sum($r['status']); ?> number of tickets were received</td>
                    <td class="text_3">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="text_3"><span class="text_3" style="text-indent:50px;"><? echo $r['status']['dispatched']; ?> have been dispatched to the concerned office</span></td>
                    <td class="text_3">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="text_3"><span class="text_3" style="text-indent:50px;"><? echo $r['status']['assigned']; ?> are currently being resolved</span></td>
                    <td class="text_3">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="text_3"><span class="text_3" style="text-indent:50px;"><? echo $r['status']['parked']; ?> are parked (spam, not for action, other issues of positive feedback)</span></td>
                    <td class="text_3">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="text_3"><span class="text_3" style="text-indent:50px;"><? echo $r['status']['closed']; ?> have been closed<br />
                    </span></td>
                    <td class="text_3">&nbsp;</td>
                  </tr>
                  <!--tr>
                    <td class="text_3" style="text-indent:50px;"><b><? echo ucwords($k); ?></b></td>
                    <td class="text_3"><b>:</b> <? echo $v; ?></td>
                  </tr>
				  <?
						if($k=='closed'){
							foreach(array_tag() as $kk=>$vv){
				  ?>
                  <tr>
                    <td class="text_1" style="text-indent:70px;"><b>- <? echo ucwords($vv); ?></b></td>
                    <td class="text_1"><b>:</b> <? if($r['closed'][$kk]) echo $r['closed'][$kk]; else echo 0; ?></td>
                  </tr>
				  <?
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
                  </tr-->
				  <?
				  	#}
				#}
					
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
        ['Dispatched',<?php echo $status['dispatched']; ?>],
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
		
         <div id="chart_div" style="width: 800px; height: 400px;"></div>
		<script type="text/javascript">
		  function drawChart() {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Barangay');
			data.addColumn('number', 'Received');
			data.addColumn('number', 'Resolved');
			data.addRows([
			  <?php
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
		  drawChart();
		</script>

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
	  unresolveOffice();
    </script>
</p>
  <div id="unresolveOffice" style="width: 800px; height: 400px;"></div>
        </fieldset>
		<div>&nbsp;</div>
<fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Reports among barangays&nbsp;&nbsp;</b></legend>
        <p><script type="text/javascript">
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
	  unresolveBrgy();
    </script>
</p>
  <div id="unresolveBrgy" style="width: 800px; height: 400px;"></div>
      </fieldset>
		<div>&nbsp;</div>
        <fieldset style="padding:20px;">
        <legend class="text_3"><b>&nbsp;&nbsp;Average Response Time Per Barangay &nbsp;&nbsp;</b></legend>
        <p><script type="text/javascript">
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
	  drawChartART();
    </script>
</p>
  <div id="chartART_div" style="width: 800px; height: 400px;"></div>
        </fieldset>
		<div>&nbsp;</div>
	</div>