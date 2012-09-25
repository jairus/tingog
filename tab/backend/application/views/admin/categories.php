<script>

function viewCat(){
	jQuery("#viewCat").html("Loading...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/categoryList",
		data: "",
		success: function(message){
			jQuery("#viewCat").html(message);
		},
	});	
}

function newCat(){
	jQuery("#newCat").html("Loading Form...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/categoryAdd",
		data: "",
		success: function(message){
			jQuery("#newCat").html(message);
		},
	});	
}
</script>
    	<div id="tabs" style="font: 100% Arial, Helvetica, sans-serif;">
			<ul>
				<li><a href="#viewCat">Category List</a></li>
				<li><a href="#newCat">Create New Category </a></li>
			</ul>
			<div id="viewCat"></div>
            <div id="newCat"></div>
		</div>
<script>
viewCat();
jQuery('#tabs').tabs({
	 select: function(event, ui) {
		if(ui.index==0){
			viewCat();
		}
		else if(ui.index==1){
			newCat();
		}
	
	}
});
</script>
