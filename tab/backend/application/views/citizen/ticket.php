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
<link rel="stylesheet" type="text/css" href="/styles/styles_1.css" />
<script type="text/javascript" src="/backend/javascript/jquery.js"></script>
<script>

function submitMessage(id){
	jQuery("#btn_message_submit_id").hide();
	mtype = jQuery('input:radio[name=option]:checked').val();
	if(mtype=='internal'){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/citizen/internalMessage/"+id,
			data: jQuery("#ticketform").serialize(),
			success: function(html){
				jQuery("#ninjadiv").html(html);
			},
		});
	}
	window.parent.citizen_tickets();
	window.parent.jQuery('#dialog_thread_id').dialog('close');
}

function viewThread(id){
	jQuery("#thread").html("Loading Thread...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/citizen/viewThread/"+id,
		data: "",
		success: function(html){
			jQuery("#thread").html(html);
		},
	});
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
                        <td>&nbsp;<?php echo zeroes($ticket['id'], 6); ?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Status</b></td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;<?php echo ucwords($ticket['status']); ?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Date Created</b></td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;<?php echo date("M d, Y H:i",strtotime($ticket['date'])); ?></td>
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
                      <tr>
                        <td width="100"><b>Category</b></td>
                        <td width="10" align="center"><b>:</b></td>
                        <td>&nbsp;<? 
						if($ticket['category']) echo $this->citymodel->getCategoryNameById($ticket['category']);
						?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Concerned Office</b></td>
                        <td align="center"><strong>:</strong></td>
                        <td>&nbsp;<?
						if($ticket['department']) echo $this->citymodel->getDepartmentNameById($ticket['department']);
						?></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Barangay</b></td>
                        <td align="center"><b>:</b></td>
                        <td>&nbsp;<?
						if($ticket['barangay']){
							$b = $this->admin->getBarangay($ticket['barangay']);
							echo $b[0]['name'];
						}
						?></td>
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
                        <td><?php echo $ticket['location']; ?></td>
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
                      <tr>
                        <td><b>Source</b></td>
                        <td align="center"><b>:</b></td>
                        <td><?php echo $ticket['source']; ?></td>
                      </tr>
                    </table>
                </div>
            </td>
          </tr>
        </table>
    </div>
    <div>&nbsp;</div>
    <div id="message_input" class="text_1">
      <input name="option" type="radio" id="option" onclick="showDropdown(0);" value="internal" checked="checked" />
    Internal Note <em></em></div>
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
