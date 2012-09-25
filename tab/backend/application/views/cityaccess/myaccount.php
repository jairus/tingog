<script>
function editSubmit(){
	jQuery.ajax({
		type: 'POST',
		url: "/backend/cityaccess/myAccountSubmit/<? echo $_SESSION['user_id']; ?>",
		data: jQuery("#editform").serialize(),
		success: function(message){
			jQuery("#message").html(message);
		},
	});
}
</script>
<table width="949" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="text_1"></td>
    </tr>
    <tr>
      <td class="text_2">
      	<div style="padding:5px;">
        	<div id='message'></div><br />
            <form id='editform'>
  			<table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td width="150">Username:</td>
                  <td><? echo $user_data[0]['user_login']; ?></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td> New Password:</td>
                  <td><input name="user_password1" type="password" id="user_password1" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Confirm New Password: </td>
                  <td><input name="user_password2" type="password" id="user_password2" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
        <tr>
                  <td>First Name: </td>
                  <td><input name="fname" type="text" id="fname" value="<? echo $user_data[0]['fname']; ?>" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Middle Name: </td>
                  <td><input name="mname" type="text" id="mname" value="<? echo $user_data[0]['mname']; ?>" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Last Name: </td>
                  <td><input name="lname" type="text" id="lname" value="<? echo $user_data[0]['lname']; ?>" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top">Address:</td>
                  <td><textarea name="address" rows="5" id="address" style="width:350px;" class="input_1"><? echo $user_data[0]['address']; ?></textarea></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Mobile:</td>
                  <td><input name="mobile" type="text" id="mobile" value="<? echo $user_data[0]['mobile']; ?>" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Email Address: </td>
                  <td><input name="email" type="text" id="email" value="<? echo $user_data[0]['email']; ?>" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type='button' value='Submit' onclick='editSubmit();' class="btn_2" style="width:100px;"></td>
                </tr>
            </table>
            </form>
      	</div>
      </td>
    </tr>
    <tr>
      <td class="text_1"><div style="padding:5px;">&nbsp;</div></td>
    </tr>
    <tr>
      <td class="text_1"></td>
    </tr>
</table>
