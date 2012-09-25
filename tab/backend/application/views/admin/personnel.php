<script>

function viewPersonnel(){
	jQuery("#viewPersonnel").html("Loading...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/personnelList",
		data: "",
		success: function(message){
			jQuery("#viewPersonnel").html(message);
		},
	});	
}

function newPersonnel(){
	jQuery("#newPersonnel").html("Loading Form...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/personnelAdd",
		data: "",
		success: function(message){
			jQuery("#newPersonnel").html(message);
		},
	});	
}
</script>
    	<div id="tabs" style="font: 100% Arial, Helvetica, sans-serif;">
			<ul>
				<li><a href="#viewPersonnel">Personnel List</a></li>
				<li><a href="#newPersonnel">Create New Personnel </a></li>
			</ul>
			<div id="viewPersonnel"></div>
            <div id="newPersonnel"></div>
		</div>
<script>
viewPersonnel();
jQuery('#tabs').tabs({
	 select: function(event, ui) {
		if(ui.index==0){
			viewPersonnel();
		}
		else if(ui.index==1){
			newPersonnel();
		}
	
	}
});
</script>
