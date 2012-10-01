<script>

function viewAccounts(){
	jQuery("#viewaccounts").html("Loading User Accounts...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/adminViewUserAccounts",
		data: "",
		success: function(message){
			jQuery("#viewaccounts").html(message);
		},
	});	
}

function newAccount(){
	jQuery("#newaccount").html("Loading Form...");
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/adminCreateNewAccount",
		data: "",
		success: function(message){
			jQuery("#newaccount").html(message);
		},
	});	
}
function add(){
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/adminCreateNewAccountSubmit",
		data: jQuery("#addform").serialize(),
		success: function(message){
			jQuery("#message").html(message);
		},
	});
}

</script>
    	<div id="tabs" style="font: 100% Arial, Helvetica, sans-serif;">
			<ul>
				<li><a href="#viewaccounts">User Accounts</a></li>
				<li><a href="#newaccount">Create New User</a></li>
			</ul>
			<div id="viewaccounts"></div>
            <div id="newaccount"></div>
		</div>
<script>
viewAccounts();
jQuery('#tabs').tabs({
	 select: function(event, ui) {
		if(ui.index==0){
			viewAccounts();
		}
		else if(ui.index==1){
			newAccount();
		}
	
	}
});
</script>
