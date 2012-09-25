<div style="height:350px;">
<div style="float:left; width:450px; height:auto;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td width="450">
            <table width="450" border="0" cellspacing="0" cellpadding="0">
            <!-- TOTAL NUMBER OF TICKETS -->
            <tr>
                <td class="text_2" width="350"><b>Total number of report(s) received</b></td>
                <td class="text_2" width="100"><b>:</b>
                <? echo array_sum($status); ?></td>
            </tr>
            <tr>
            	<td class="text_2" colspan="2">&nbsp;</td>
            </tr>
            <? foreach($status as $k=>$v){ 
				$label = $k;
				if($k=='parked'){
					$label = "Others";
				}
				?>
                <tr>
                    <td class="text_5" style="text-indent:50px; padding-bottom:5px;"><b><? echo ucwords($label); ?></b></td>
                    <td class="text_5"><b>:</b> <? echo $v; ?></td>
                </tr>
                <?
                if($k=='closed'){
                    foreach($closed as $kk=>$vv){
                        if($kk){
							?>
							<tr>
								<td class="text_4" style="text-indent:70px; padding-bottom:5px;"><b>- <? echo ucwords(array_tag($kk)); ?></b></td>
								<td class="text_4"><b>:</b> <? echo $vv; ?></td>
							</tr>
							<?
                        }
                    }
                }
                
                if($k=='parked'){
                    foreach($parked as $kk=>$vv){
                        if($kk){
							?>
							<tr>
								<td class="text_4" style="text-indent:70px; padding-bottom:5px;"><b>- <? echo ucwords(array_parked($kk)); ?></b></td>
								<td class="text_4"><b>:</b> <? echo $vv; ?></td>
							</tr>
							<?
                        }
                    }
                }
                
                if($k=='resolved' && isset($average_response)){
                ?>
                <tr>
                    <td class="text_4" style="text-indent:70px; padding-bottom:5px;"><b>- Avg Response Time</b></td>
                    <td class="text_4"><b>:</b> <? echo $average_response.' day(s)'; ?></td>
                </tr>
                <?
                }
            }
            ?>
            </table>
    	</td>
    	<td></td>
    </tr>
</table>
</div>
<div style="float:left; width:500px; height:auto;">
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
        ['Others',<?php echo $status['parked']; ?>],
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
</div>
</div>