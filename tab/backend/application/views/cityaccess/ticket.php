<?php
	$ticket = $ticket[0];
	$data = array();
	$data['ticket'] = $ticket;
	$data['messages'] = $messages;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>View Report</title>
<link rel="Shortcut Icon" href="/images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="/backend/styles/styles_1.css" />
<script type="text/javascript" src="/backend/javascript/jquery.js"></script>
<script>

function submitMessage(id){
	jQuery("#btn_message_submit_id").hide();
	mtype = jQuery('input:radio[name=option]:checked').val();
	if(mtype=='internal'){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/cityaccess/internalMessage/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
				jQuery("#btn_message_submit_id").show();
			},
		});
	}
	else if(mtype=='park'){
		if(!confirm("Are you sure?")){
			jQuery("#btn_message_submit_id").hide();
			return false;
		}
		jQuery.ajax({
			type: 'POST',
			url: "/backend/cityaccess/parkTicket/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
			},
		});
		window.parent.jQuery('#dialog_thread_id').dialog('close');
	}
	else if(mtype=='reply'){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/cityaccess/sendReply/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
				jQuery("#btn_message_submit_id").show();
			},
		});
		
	}
	
	else if(mtype=='dispatch'){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/cityaccess/dispatchTicket/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
			},
		});
		window.parent.jQuery('#dialog_thread_id').dialog('close');
	}

	else if(mtype=='tag'){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/cityaccess/tagTicket/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
				
			},
		});
		window.parent.jQuery('#dialog_thread_id').dialog('close');
	}
	window.parent.cityaccess_tickets();
	//window.parent.jQuery('#dialog_thread_id').dialog('close');
}

function submitTag(id){
	jQuery.ajax({
		type: 'POST',
		url: "/backend/cityaccess/tagTicket/"+id,
		data: jQuery("#ticketform").serialize(),
		success: function(html){
			jQuery("#ninjadiv").html(html);
			jQuery("#btn_message_submit_id").show();
		},
	});
	window.parent.cityaccess_tickets();
}

function viewThread(id){
	jQuery("#thread").html("Loading Thread...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/cityaccess/viewThread/"+id,
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

function check_barangay(v){
	if(v=='other'){
		jQuery(".barangay").show();
		jQuery(".barangay*").attr("disabled", false);
	}else{
		jQuery(".barangay").hide();
		jQuery(".barangay*").attr("disabled", true);
	}
}

</script>
</head>

<body>
<div id='ninjadiv' style="display:none"></div>
<table width='100%'><tr><td>
	<div style="overflow:scroll; height:250px;" id='thread'></div>
	<script>
		viewThread("<?php echo $ticket['id']; ?>");
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
                      <tr class='dispatchonly'>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr class="barangay" style="display:none;">
                        <td>Barangay Name</td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;<input name="name" type="text" id="name" class="input_1" /></td>
                      </tr>
                      <tr class="barangay" style="display:none;">
                        <td>&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr class="barangay" style="display:none;">
                        <td>Longitude</td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;<input name="long" type="text" id="long" class="input_1" /></td>
                      </tr>
                      <tr class="barangay" style="display:none;">
                        <td>&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr class="barangay" style="display:none;">
                        <td>Latitude</td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;<input name="lat" type="text" id="lat" class="input_1" /></td>
                      </tr>
                      <tr class='dispatchonly'>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr class='dispatchonly'>
                        <td><b>Barangay</b></td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;<select name="brgy" class="input_1" id="brgy" onchange="check_barangay(this.value);">
						  <option value="0">-</option>
						  <?
						  	foreach($barangay as $k=>$v){
								echo "<option value=\"".$v['id']."\">".$v['name']."</option>";
							}
						  ?>
						  <option value="other">Other</option>
                        </select></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
					  <?
					  	if($ticket['status']!='closed'){
					  ?>
                      <tr class='dispatchonly'>
                        <td width="100"><b>Category</b></td>
                        <td width="10" align="center"><b>:</b></td>
                        <td>
							<?php
							if($ticket['status']=='dispatched'){
								echo $category;
							}else{
								$t = count($categories);
								if($t){
									echo '&nbsp;<select id="category_id" name="category_id" class="input_1" style="width:150px;">';
									echo "<option value=\"\">-</option>";
									for($i=0; $i<$t; $i++){
										echo "<option value=\"".$categories[$i]->id."\">".$categories[$i]->category."</option>";
									}
									echo "</select>";
								}
							}
							?>                        </td>
                      </tr>
                      <tr class='dispatchonly'>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr class='dispatchonly'>
                        <td><b>Concerned Office</b></td>
                        <td align="center"><strong>:</strong></td>
                        <td><?php
							if($ticket['status']=='dispatched'){
								echo $department;
							}else{
								$t = count($departments);
								if($t){
									echo '&nbsp;<select id="department_id" name="department_id" class="input_1" style="width:150px;">';
									echo "<option value=\"\">-</option>";
									for($i=0; $i<$t; $i++){
										echo "<option value=\"".$departments[$i]->id."\">".$departments[$i]->department."</option>";
									}
									echo "</select>";
								}
							}
							?></td>
                      </tr>
					  <?
					  	}
						
						if($ticket['status']=='closed'){
							// Resolved w/ verification, Resolve w/out verification, Positive Feedback, Not for action, Other issues, Spam
					  ?>
					  <tr>
                        <td><b>Tag:</b></td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;<select name="tag" id="tag" class="input_1" style="width:150px;">
                          <?
						  	echo "<option value=\"\">-</option>";
						  	foreach(array_tag(false) as $k=>$v){
								echo "<option value=\"".$k."\">".$v."</option>";
							}
						  ?></select>                        </td>
                      </tr>
					  <?
					  	}
						$array_parked = array_parked();
					  ?>
                      <tr class='parkonly'>
                        <td colspan="3" class='parkonly'>&nbsp;</td>
                      </tr>
					  <tr class='parkonly' style="display:none;">
                        <td width="100"><b>Others:</b></td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;<select name="park_tag" id="park_tag" class="input_1" style="width:150px;">
                          <?
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
                        <td><?php echo $ticket['name']; ?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><strong>Barangay</strong></td>
                        <td align="center"><strong>:</strong></td>
                        <td><?php echo $ticket['location']; ?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><strong>Phone</strong></td>
                        <td align="center"><strong>:</strong></td>
                        <td><?php echo $ticket['number']; ?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Email</b></td>
                        <td align="center"><b>:</b></td>
                        <td><?php echo $ticket['email']; ?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Source</b></td>
                        <td align="center"><b>:</b></td>
                        <td><?php echo $ticket['source']; ?></td>
                      </tr>
                      <!--tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
					  <?
					  	if($ticket['status']!='closed'){
					  ?>
                      <tr class="smsonly" style="display:none;">
                        <td colspan="3" style="padding-bottom:5px;"><input name="action" type="radio" value="1" checked="checked" /> 
                        Send Full Message SMS</td>
                      </tr>
                      <tr class="smsonly" style="display:none;">
                        <td colspan="3" style="padding-bottom:5px;"><input name="action" type="radio" value="2" /> 
                        Send SMS Notification</td>
                      </tr>
                      <tr class="smsonly" style="display:none;">
                        <td colspan="3"><input name="action" type="radio" value="3" /> 
                        No SMS </td>
                      </tr>
					  <?
					  	}
					  ?>!-->
                    </table>
                </div>
            </td>
          </tr>
        </table>
    </div>
    <div>&nbsp;</div>
    <div id="message_input" class="text_1">
	<?php
	if($ticket['status']!='closed'){
		if($ticket['status']!='dispatched'){
			?>
			<input id="option" name="option" type="radio" value="dispatch" checked="checked" onclick="showDropdown(1);" /> 
			Dispatch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<?
		}
		?><input id="option" name="option" type="radio" value="internal" onclick="showDropdown(0);" />
		 Internal Note &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		 <input id="option" name="option" type="radio" value="reply" onclick="showDropdown(0);" /> 
		Reply to Sender &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<?
		if($ticket['status']!='dispatched'){
			if($ticket['status']!='parked'){
				?>
				<input id="option" name="option" type="radio" value="park" onclick="showDropdown(2);" /> 
				Others &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				<?php
			}
		}
	}
	?>
    </div>
    <div>&nbsp;</div>
    <div id="message_input" class="text_1"></div>
	<?
		if($ticket['status']!='closed'){
	?>
	<div id="message_input"><textarea id="textarea_message_id" name="message" rows="5" cols="100" class="input_1"></textarea></div>
	<div id="message_input"><center><br><input type="button" id="btn_message_submit_id" name="btn_message_submit" class="btn_3" value="Submit" style="width:130px;" onclick='submitMessage("<?php echo $ticket['id']; ?>");' /></center></div>
	<?
		}else{
	?>
	<div id="message_input"><center><br><input type="button" id="btn_message_submit_id" name="btn_message_submit" class="btn_3" value="OK" style="width:130px;" onclick='submitTag("<?php echo $ticket['id']; ?>");' /></center></div>
	<?
		}
	?>
  </form>
</td></tr>
</table>
</body>
</html>
