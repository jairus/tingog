<script>

function viewUsers(){
	jQuery("#viewusers").html("Loading users...");
	jQuery.ajax({
		type: 'POST',
		url: "/sample/viewusers",
		data: "",
		success: function(message){
			jQuery("#viewusers").html(message);
		},
	});	
}
function add(){
	jQuery.ajax({
		type: 'POST',
		url: "/sample/add",
		data: jQuery("#addform").serialize(),
		success: function(message){
			jQuery("#message").html(message);
		},
	});
}
</script>

<div id="usertabs" style="font: 100% Arial, Helvetica, sans-serif;">
	<ul>
		<li><a href="#viewusers">View Users</a></li>
		<li><a href="#createuser">Create User</a></li>
	</ul>
	<div id="viewusers">
		
	</div>
	<div id="createuser">
		<div id='message'></div>
		<br>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
  				<form id='addform'>
                <tr>
                  <td width="150">Username:</td>
                  <td><input type='text' name='username' value=''></td>
                </tr>
                <tr>
                  <td> Password:</td>
                  <td><input name="password" type="password" id="user_password1" /></td>
                </tr>
                <tr>
                  <td>Confirm Password: </td>
                  <td><input name="user_password2" type="password" id="user_password2" /></td>
                </tr>
        <tr>
                  <td>First Name: </td>
                  <td><input name="fname" type="text" id="fname" /></td>
                </tr>
                <tr>
                  <td>Middle Name: </td>
                  <td><input name="mname" type="text" id="mname" /></td>
                </tr>
                <tr>
                  <td>Last Name: </td>
                  <td><input name="lname" type="text" id="lname" /></td>
                </tr>
                <tr>
                  <td valign="top">Address:</td>
                  <td><textarea name="address" rows="5" id="address" style="width:350px;"></textarea></td>
                </tr>
                <tr>
                  <td>Access Level :</td>
                  <td><select name="access_level" id="access_level">
				        <?
							foreach($accesslevel as $k=>$v){
								$x = std2arr($v['access']);
								echo '<option value="'.$x['id'].'">'.$x['name'].'</option>';
							}
						?>
                  </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type='button' value='Submit' onclick='add();'></td>
                </tr>
                </form>
            </table>
	</div>
</div>

<script>
viewUsers();
jQuery('#usertabs').tabs({
	 select: function(event, ui) {
		//if tab 0 "View Users" is clicked
		if(ui.index==0){
			viewUsers();
		}
		//if tab 1 "Create User" is clicked
		else if(ui.index==1){
			
		}
	
	}
});
</script>
