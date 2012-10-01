<script>
function editSubmit(){
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/adminEditAccountSubmit/<? echo $user_data[0]['id']; ?>",
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
      <td class="text_1">
      	<div style="padding:5px;">
        	<div id='message'></div><br />
            <form id='editform'>
  			<table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td width="150">Username:</td>
                  <td><? echo $user_data[0]['user_login']; ?></td>
                </tr>
                <tr>
                  <td> New Password:</td>
                  <td><input name="user_password1" type="password" id="user_password1" /></td>
                </tr>
                <tr>
                  <td>Confirm New Password: </td>
                  <td><input name="user_password2" type="password" id="user_password2" /></td>
                </tr>
        <tr>
                  <td>First Name: </td>
                  <td><input name="fname" type="text" id="fname" value="<? echo $user_data[0]['fname']; ?>" /></td>
                </tr>
                <tr>
                  <td>Middle Name: </td>
                  <td><input name="mname" type="text" id="mname" value="<? echo $user_data[0]['mname']; ?>" /></td>
                </tr>
                <tr>
                  <td>Last Name: </td>
                  <td><input name="lname" type="text" id="lname" value="<? echo $user_data[0]['lname']; ?>" /></td>
                </tr>
                <tr>
                  <td valign="top">Address:</td>
                  <td><textarea name="address" rows="5" id="address" style="width:350px;"><? echo $user_data[0]['address']; ?></textarea></td>
                </tr>
                <tr>
                  <td>Access Level:</td>
                  <td><select name="access_level" id="access_level">
				        <?
							foreach($accesslevel as $k=>$v){
								$x = std2arr($v['access']);
								echo '<option value="'.$x['id'].'" ';
								if($x['id']==$user_data[0]['access_level']) echo "selected";
								echo '>'.$x['name'].'</option>';
							}
						?>
                  </select></td>
                </tr>
                <tr>
                  <td>Concerned Office:</td>
                  <td><?php
							#if($ticket['status']=='dispatched'){
							#	echo $department;
							#}else{
							#pre($user_data);
								$t = count($departments);
								if($t){
									echo '<select id="department_id" name="department_id">';
									echo "<option value=\"\">--</option>";
									for($i=0; $i<$t; $i++){
										echo "<option value=\"".$departments[$i]->id."\" ";
										if($user_data[0]['department']==$departments[$i]->id) echo "selected";
										echo ">".$departments[$i]->department."</option>";
									}
									echo "</select>";
								}
							#}
							?></td>
                </tr>
                <tr>
                  <td>Mobile:</td>
                  <td><input name="mobile" type="text" id="mobile" value="<? echo $user_data[0]['mobile']; ?>" /></td>
                </tr>
                <tr>
                  <td>Email Address: </td>
                  <td><input name="email" type="text" id="email" value="<? echo $user_data[0]['email']; ?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type='button' value='Submit' onclick='editSubmit();'></td>
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
