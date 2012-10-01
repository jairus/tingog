<script type="text/javascript">
function submitMessage(){
	alert('Message posted');	
	return false;
}
function openThreadDialog(id){
	jQuery("#dialogiframe")[0].src = '/backend/citizen/viewticket/'+id;
	jQuery.ajax({
		success: function() {
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
		width: 655
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

function citizen_tickets(){
	jQuery("#citizen_tickets").html("Loading Reports...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/citizen/viewTicketList",
		data: "",
		success: function(message){
			jQuery("#citizen_tickets").html(message);
		},
	});	
}

function masterList(){
	jQuery("#cityaccess_masterlist").html("Loading...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/cityaccess/masterList",
		data: "",
		success: function(message){
			jQuery("#cityaccess_masterlist").html(message);
		},
	});	
}

function directory(){
	jQuery("#cityaccess_directory").html("Loading...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/cityaccess/directory",
		data: "",
		success: function(message){
			jQuery("#cityaccess_directory").html(message);
		},
	});	
}

function summary(){
	jQuery("#cityaccess_summary").html("Loading...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/cityaccess/summary",
		data: "",
		success: function(message){
			jQuery("#cityaccess_summary").html(message);
		},
	});	
}

function myAccount(){
	jQuery("#cityaccess_myaccount").html("Loading...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/cityaccess/myAccount",
		data: "",
		success: function(message){
			jQuery("#cityaccess_myaccount").html(message);
		},
	});	
}


</script>
<?php
$this->load->view('cityaccess/dialog.php');
?>
<div id="tabs" style="font: 100% Arial, Helvetica, sans-serif;">
	<ul>
		<li><a href="#citizen_tickets">Reports</a></li>
		<li><a href="#cityaccess_summary">Summary Reports</a></li>
		<li><a href="#cityaccess_masterlist">Masterlist</a></li>
		<li><a href="#cityaccess_directory">Directory</a></li>
		<li><a href="#cityaccess_myaccount">My Account</a></li>
	</ul>
	<div id="citizen_tickets"></div>
	<div id="cityaccess_masterlist"></div>
	<div id="cityaccess_directory"></div>
	<div id="cityaccess_summary"></div>
	<div id="cityaccess_myaccount"></div>
</div>
<script>
citizen_tickets();
jQuery('#tabs').tabs({
	 select: function(event, ui) {
		if(ui.index==0){
			citizen_tickets();
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