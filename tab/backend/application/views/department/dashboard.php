<script type="text/javascript">
function submitMessage(){
	alert('Message posted');	
	return false;
}
function openThreadDialog(id){
	jQuery('#pleasewait_1').show();
	
	
	jQuery("#dialogiframe")[0].src = '/backend/department/depviewticket/'+id;
	
	jQuery.ajax({
		success: function() {
			jQuery('#pleasewait_1').hide();
			jQuery('#dialog_thread_id').dialog('open');
		}
	});
	
	return false;
}

jQuery(function(){
	//SUBMIT MESSAGE
	jQuery('#btn_message_submit_id, ul#icons li').hover(
		function() { jQuery(this).addClass('ui-statedialog-hover'); }, 
		function() { jQuery(this).removeClass('ui-statedialog-hover'); }
	);
	//END OF SUBMIT MESSAGE
		   
	//OPEN THREAD
	jQuery('#dialog_thread_id').dialog({
		autoOpen: false,
		width: 1100
	});
	//END OF OPEN THREAD
});
<!--END OF OPEN DIALOG BOX-->

function showDropdown(x){
	if(x==1){
		jQuery("#dropdown_id").show();
	}else if(x==0){
		jQuery("#dropdown_id").hide();
	}
}

function department_tickets(){
	jQuery("#department_tickets").html('<img src="/backend/images/loading.gif">');
	jQuery.ajax({
		type: 'POST',
		url: "/backend/department/depListTicket",
		data: "",
		success: function(message){
			jQuery("#department_tickets").html(message);
		},
	});	
}

function masterList(){
	jQuery("#department_masterlist").html('<img src="/backend/images/loading.gif">');
	jQuery.ajax({
		type: 'POST',
		url: "/backend/department/masterList",
		data: "",
		success: function(message){
			jQuery("#department_masterlist").html(message);
		},
	});	
}

function directory(){
	jQuery("#department_directory").html('<img src="/backend/images/loading.gif">');
	jQuery.ajax({
		type: 'POST',
		url: "/backend/department/directory",
		data: "",
		success: function(message){
			jQuery("#department_directory").html(message);
		},
	});	
}

function summary(){
	jQuery("#department_summary").html('<img src="/backend/images/loading.gif">');
	jQuery.ajax({
		type: 'POST',
		url: "/backend/department/summary",
		data: "",
		success: function(message){
			jQuery("#department_summary").html(message);
		},
	});	
}

function myAccount(){
	jQuery("#department_myaccount").html('<img src="/backend/images/loading.gif">');
	jQuery.ajax({
		type: 'POST',
		url: "/backend/department/myAccount",
		data: "",
		success: function(message){
			jQuery("#department_myaccount").html(message);
		},
	});	
}




</script>
<?php
$this->load->view('department/dialog.php');
?>
<div id="tabs" style="font: 100% Arial, Helvetica, sans-serif;">
  <ul>
	<li><a href="#department_tickets">Reports</a></li>
	<li><a href="#department_summary">Summary Reports</a></li>
	<li><a href="#department_masterlist">Masterlist</a></li>
	<li><a href="#department_directory">Directory</a></li>
	<li><a href="#department_myaccount">My Account</a></li>
  </ul>
  <div id="department_tickets"></div>
  <div id="department_masterlist"></div>
  <div id="department_directory"></div>
  <div id="department_summary"></div>
  <div id="department_myaccount"></div>
</div>
<script>
department_tickets();
jQuery('#tabs').tabs({
	 select: function(event, ui) {
		if(ui.index==0){
			department_tickets();
		}
		else if(ui.index==1){
			summary();
		}
		else if(ui.index==2){
			masterList();
		}
		else if(ui.index==3){
			directory();
		}
		else if(ui.index==4){
			myAccount();
		}
	}
});
</script>