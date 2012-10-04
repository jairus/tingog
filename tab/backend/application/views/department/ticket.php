<?php
@session_start();
	$ticket = $ticket[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>View Report</title>
<link rel="Shortcut Icon" href="/images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="/styles/styles_1.css" />
<script type="text/javascript" src="/backend/javascript/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="/backend/styles/jquery.ui.datepicker.css" />
<script src="/backend/javascript/datepicker/jquery.ui.core.js"></script>
<script src="/backend/javascript/datepicker/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/backend/javascript/datepicker/jquery.ui.datepicker.js"></script>
<script>
$(function() {
	$( "#datepicker" ).datepicker();
});
</script>
<script>

function submitMessage(id){
	jQuery("#btn_message_submit_id").hide();
	mtype = jQuery('input:radio[name=option]:checked').val();
	//alert(mtype);
	if(mtype=='assign'){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/department/assign/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
				jQuery("#btn_message_submit_id").hide();
			},
		});
		window.parent.jQuery('#dialog_thread_id').dialog('close');
	}
	else if(mtype=='park'){
		if(!confirm("Are you sure?")){
			jQuery("#btn_message_submit_id").show();
			return false;
		}
		jQuery.ajax({
			type: 'POST',
			url: "/backend/department/parkTicket/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
				jQuery("#btn_message_submit_id").hide();
			},
		});
		window.parent.jQuery('#dialog_thread_id').dialog('close');
	}
	else if(mtype=='return'){
		if(!confirm("Are you sure you want to return this report to dispatcher?")){
			jQuery("#btn_message_submit_id").show();
			return false;
		}
		jQuery.ajax({
			type: 'POST',
			url: "/backend/department/returnTicket/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
				jQuery("#btn_message_submit_id").hide();
			},
		});
		window.parent.jQuery('#dialog_thread_id').dialog('close');
	}
	else if(mtype=='resolve'){
		if(!confirm("Are you sure you want to resolve this report?")){
			jQuery("#btn_message_submit_id").show();
			return false;
		}
		jQuery.ajax({
			type: 'POST',
			url: "/backend/department/resolveTicket/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
				jQuery("#btn_message_submit_id").hide();
			},
		});
		window.parent.jQuery('#dialog_thread_id').dialog('close');
	}
	else if(mtype=='internal'){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/department/internalMessage/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
				jQuery("#btn_message_submit_id").hide();
			},
		});
		jQuery("#btn_message_submit_id").show();
	}
	else if(mtype=='internalwsms'){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/department/internalMessage/"+id,
			data: jQuery("#ticketform").serialize()+"&sms[]=<?php echo $personnelcomplete1['mobile']; ?>&sms[]=<?php echo $personnelcomplete2['mobile']; ?>&ticket_id=<?php echo $ticket['id']; ?>",
			success: function(html){
				jQuery("#ninjadiv").html(html);
				jQuery("#btn_message_submit_id").hide();
			},
		});
		jQuery("#btn_message_submit_id").show();
	}
	else if(mtype=='reply'){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/department/sendReply/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
				jQuery("#btn_message_submit_id").hide();
			},
		});
		jQuery("#btn_message_submit_id").show();
	}
	window.parent.department_tickets();
}

function viewThread(id){
	jQuery("#thread").html("Loading Thread...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/department/viewThread/"+id,
		data: "",
		success: function(html){
			jQuery("#thread").html(html);
		},
	});
}

function showDropdown(flag){
	jQuery(".parkonly").hide();
	jQuery(".parkonly *").attr("disabled", true);
	jQuery(".smsonly").show();
	jQuery(".smsonly *").attr("disabled", false);
	
	if(flag==1){
		jQuery(".dispatchonly").show();
		jQuery(".dispatchonly *").attr("disabled", false);
	}
	//internal with sms
	else if(flag==3){
		jQuery(".dispatchonly").show();
		jQuery(".dispatchonly *").attr("disabled", false);
		jQuery("#textarea_message_id").val("<?php
		echo "Para mag-reply sa Tingog, i-text ang TINGOG REP ".$_SESSION['municipality'].$ticket['id']."/<message>";
		?>");
	}
	else if(flag==0){
		jQuery(".dispatchonly").hide();
		jQuery(".dispatchonly *").attr("disabled", true);
	}
	else if(flag==2){
		
		jQuery(".dispatchonly").hide();
		jQuery(".dispatchonly *").attr("disabled", true);
		jQuery(".smsonly").hide();
		jQuery(".smsonly *").attr("disabled", true);
		
		jQuery(".parkonly").show();
		jQuery(".parkonly *").attr("disabled", false);
	}
}
</script>

</head>

<body>
<?php
?>
<div id='ninjadiv' style="display:none"></div>
<table width='100%'><tr><td>
	<div style="overflow:scroll; height:250px;" id='thread'>
    </div>
	<script>
		<?
			if(isset($ticket['id'])){
				echo 'viewThread("'.$ticket['id'].'");';
			}
		?>
	</script>
    <div>&nbsp;</div>
	<div id='message'></div><br />
	<form id="ticketform" name="ticketform" method="post" action="">
	<div>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" class="text_2" valign="top">
            	<div style="padding:5px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="100"><b>Report #</b></td>
                        <td width="10" align="center"><b>:</b></td>
                        <td><?php echo zeroes($ticket['id'], 6); ?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Status</b></td>
                        <td align="center"><b>:</b></td>
                        <td><?php echo ucwords($ticket['status']); ?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Date Created</b></td>
                        <td align="center"><b>:</b></td>
                        <td><?php echo date("M d, Y H:i",strtotime($ticket['date'])); ?></td>
                      </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dropdown_id">
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3" style="border-bottom:1px dotted #CCC;"></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr class='dispatchonly'>
                        <td><b>Issue</b></td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;
                            <?php
							if($ticket['status']=='assigned' || $ticket['status']=='resolved'){
								echo $issue;
							}else{
								$t = count($issues);
								if($t){
									echo '<select id="issue_id" name="issue_id" class="input_1" style="width:150px;">';
									echo "<option value=\"\">-</option>";
									for($i=0; $i<$t; $i++){
										echo "<option value=\"".$issues[$i]->id."\" ";
										if($ticket['issue']==$issues[$i]->id) echo "selected;";
										echo ">".$issues[$i]->issue."</option>";
									}
									echo "</select>";
								}
							}
							?>
						</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr class='dispatchonly'>
                        <td><b>Personnel 1</b></td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;
                            <?php
							if($ticket['status']=='assigned' || $ticket['status']=='resolved'){
								if($personnelcomplete1){
									//Array ( [id] => 5 [person] => Jason Diaz [department] => 1 [mobile] => 09273779066 )
									echo $personnelcomplete1['person'];
									if(trim($personnelcomplete1['mobile'])){
										echo " (".trim($personnelcomplete1['mobile']).")";
									}
									else{
										echo " (no mobile name)";
									}
								}
								else{
									echo $personnel;
								}
							}else{
								$t = count($personnels);
								if($t){
									echo '<select id="personnel_id" name="personnel_id" class="input_1" style="width:150px;">';
									echo "<option value=\"\">-</option>";
									for($i=0; $i<$t; $i++){
										echo "<option value=\"".$personnels[$i]->id."\" ";
										if($ticket['assign1']==$personnels[$i]->id) echo "selected;";
										echo ">".$personnels[$i]->person."</option>";
									}
									echo "</select>";
								}
							}
							?>
					    </td>
                      </tr>
					  <?
					  	#if(trim($personnel2)){
					  ?>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr class='dispatchonly'>
                        <td><b>Personnel 2</b></td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;
                            <?php
							if($ticket['status']=='assigned' || $ticket['status']=='resolved'){
								if($personnelcomplete2){
									//Array ( [id] => 5 [person] => Jason Diaz [department] => 1 [mobile] => 09273779066 )
									echo $personnelcomplete2['person'];
									if(trim($personnelcomplete2['mobile'])){
										echo " (".trim($personnelcomplete2['mobile']).")";
									}
									else{
										echo " (no mobile name)";
									}
								}
								else{
									echo $personnel2;
								}
							}else{
								$t = count($personnels);
								if($t){
									echo '<select id="personnel_id2" name="personnel_id2" class="input_1" style="width:150px;">';
									echo "<option value=\"\">-</option>";
									for($i=0; $i<$t; $i++){
										echo "<option value=\"".$personnels[$i]->id."\" ";
										if($ticket['assign1']==$personnels[$i]->id) echo "selected;";
										echo ">".$personnels[$i]->person."</option>";
									}
									echo "</select>";
								}
							}
							?>
					    </td>
                      </tr>
					  <?
					  	#}
					  ?>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
					  <?php
					  	#pre($ticket);
					  	if(($ticket['status']=='resolved' || $ticket['status']=='assigned'  ) ){
							if(strtotime($ticket['duedate'])){
						  ?>
						  <tr class='dispatchonly'>
							<td><b>Due Date</b></td>
							<td align="center"><b>:</b></td>
							<td>&nbsp;<?php
								echo date("M d, Y",strtotime($ticket['duedate']));
								//&nbsp;<input name="datepicker" type="text" id="datepicker" class="input_1" style="width:150px;"/>
							?></td>
						  </tr>
						  <?php
					  		}
						}
						else{
						  ?>
						  <tr class='dispatchonly'>
							<td><b>Due Date</b></td>
							<td align="center"><b>:</b></td>
							<td>
								&nbsp;<input name="datepicker" type="text" id="datepicker" class="input_1" style="width:150px;"/>
							</td>
						  </tr>
						  <?php
						}
					  ?>
                      <tr class='parkonly'>
                        <td colspan="3" class='parkonly'>&nbsp;</td>
                      </tr>
					  <tr class='parkonly' style="display:none;">
                        <td width="100"><b>Others:</b></td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;<select name="park_tag" id="park_tag" class="input_1" style="width:150px;">
                          <?
						  	$array_parked = array_parked();
							echo "<option value=\"\">-</option>";
							foreach($array_parked as $k=>$v){
								echo '<option value="'.$k.'">'.$v.'</option>';
							}
						  ?>
                        </select></td>
                      </tr>
                    </table>
                </div>
            </td>
            <td width="50%" class="text_2" valign="top">
            	<div style="padding:5px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="100"><b>Name</b></td>
                        <td width="10" align="center"><b>:</b></td>
                        <td><!--- HIDDEN --->&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Email</b></td>
                        <td align="center"><b>:</b></td>
                        <td><!--- HIDDEN --->&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Barangay</b></td>
                        <td align="center"><b>:</b></td>
                        <td><?php echo $ticket['barangay']; ?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Phone</b></td>
                        <td align="center"><b>:</b></td>
                        <td><!--- HIDDEN --->&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
					  <?php if(trim($ticket['source'])){ ?>
                      <tr>
                        <td><b>Source</b></td>
                        <td align="center"><b>:</b></td>
                        <td><?php echo $ticket['source']; ?></td>
                      </tr>
					  
                      <?php
							}
							if($ticket['status']!='assigned'){
					  ?>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr style="display:none;">
                        <td colspan="3" style="padding-bottom:5px;"><input name="action" type="radio" value="1" checked="checked" />
                          Send Full Message SMS</td>
                      </tr>
                      <tr style="display:none;">
                        <td colspan="3" style="padding-bottom:5px;"><input name="action" type="radio" value="2" />
                          Send SMS Notification</td>
                      </tr>
                      <tr style="display:none;">
                        <td colspan="3"><input name="action" type="radio" value="3" />
                          No SMS</td>
                      </tr>
					  <?
					  		}
					  ?>
                    </table>
                </div>
            </td>
          </tr>
        </table>
    </div>
    <div>&nbsp;</div>
    <div id="message_input" class="text_1">
      <?php 
	  	#pre($ticket['status']);
	  	if(($ticket['status']!='assigned') || ($ticket['status']!='resolved')){
			if($ticket['status']!='assigned' && ($ticket['status']!='resolved')){
	  ?>
	  <input name="option" type="radio" value="assign" checked="checked" onclick="showDropdown(1);" />
Assign &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <?php
	  		}
			
			if($ticket['status']!='resolved'){
	  ?>
	  <input name="option" type="radio" value="resolve" onclick="showDropdown(1);" />
Resolve &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
			}
		}
?>
<input name="option" type="radio" value="return" onclick="showDropdown(0);" />
Return to dispatcher &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="option" type="radio" value="internal" onclick="showDropdown(1);" />
Internal Note &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="option" type="radio" value="internalwsms" onclick="showDropdown(3);" />
Internal Note (SMS to assignee) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="option" type="radio" value="reply" onclick="showDropdown(0);" /> 
Reply to Sender &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input name="option" type="radio" value="park" onclick="showDropdown(2);" />
Others &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
</div>
    <div>&nbsp;</div>
    <div id="message_input" class="text_1"></div>
    <div id="message_input"><textarea id="textarea_message_id" name="message" rows="5" cols="100" class="input_1"></textarea>
    </div>
		<div id="message_input"><center><br><input type="button" id="btn_message_submit_id" name="btn_message_submit" class="btn_3" value="Submit" style="width:130px;" onclick='submitMessage("<?php echo $ticket['id']; ?>");' /></center></div>
  </form>
</td></tr>
</table>
</body>
</html>
