<script>

function viewIssues(){
	jQuery("#viewIssues").html("Loading...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/issueList",
		data: "",
		success: function(message){
			jQuery("#viewIssues").html(message);
		},
	});	
}

function newIssue(){
	jQuery("#newIssue").html("Loading Form...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/issueAdd",
		data: "",
		success: function(message){
			jQuery("#newIssue").html(message);
		},
	});	
}
</script>
    	<div id="tabs" style="font: 100% Arial, Helvetica, sans-serif;">
			<ul>
				<li><a href="#viewIssues">Issue List</a></li>
				<li><a href="#newIssue">Create New Issue </a></li>
			</ul>
			<div id="viewIssues"></div>
            <div id="newIssue"></div>
		</div>
<script>
viewIssues();
jQuery('#tabs').tabs({
	 select: function(event, ui) {
		if(ui.index==0){
			viewIssues();
		}
		else if(ui.index==1){
			newIssue();
		}
	
	}
});
</script>
