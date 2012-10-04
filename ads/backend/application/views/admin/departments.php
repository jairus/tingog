<script>

function viewDepartments(){
	jQuery("#viewDepartments").html("Loading...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/departmentsList?sadas",
		data: "",
		success: function(message){
			jQuery("#viewDepartments").html(message);
		},
	});	
}

function newDepartment(){
	jQuery("#newDepartment").html("Loading Form...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/departmentsAdd",
		data: "",
		success: function(message){
			jQuery("#newDepartment").html(message);
		},
	});	
}
</script>
    	<div id="tabs" style="font: 100% Arial, Helvetica, sans-serif;">
			<ul>
				<li><a href="#viewDepartments">Department List</a></li>
				<li><a href="#newDepartment">Create Concerned Office </a></li>
			</ul>
			<div id="viewDepartments"></div>
            <div id="newDepartment"></div>
</div>
<script>
viewDepartments();
jQuery('#tabs').tabs({
	 select: function(event, ui) {
		if(ui.index==0){
			viewDepartments();
		}
		else if(ui.index==1){
			newDepartment();
		}
	
	}
});
</script>
