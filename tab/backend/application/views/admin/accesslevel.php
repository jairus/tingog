<script>

function viewAccess(){
	jQuery("#viewAccess").html("Loading Access Levels...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/accessLevelList",
		data: "",
		success: function(message){
			jQuery("#viewAccess").html(message);
		},
	});	
}

function newAccess(){
	jQuery("#newAccess").html("Loading Access Levels...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/accessLevelAdd",
		data: "",
		success: function(message){
			jQuery("#newAccess").html(message);
		},
	});	
}
</script>
    	<div id="tabs" style="font: 100% Arial, Helvetica, sans-serif;">
			<ul>
				<li><a href="#viewAccess">Access Level List</a></li>
				<li><a href="#newAccess">Create New Access Level</a></li>
			</ul>
			<div id="viewAccess"></div>
            <div id="newAccess"></div>
		</div>
<script>
viewAccess();
jQuery('#tabs').tabs({
	 select: function(event, ui) {
		//if tab 0 "View Users" is clicked
		if(ui.index==0){
			viewAccess();
		}
		//if tab 1 "Create User" is clicked
		else if(ui.index==1){
			newAccess();
		}
	}
});
</script>
