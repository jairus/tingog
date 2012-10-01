<script>
function addSubmit(){
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
<table width="949" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="text_1"></td>
    </tr>
    <tr>
      <td class="text_2">
      	<div style="padding:5px;">
        	<div id='message'></div><br />
            <form id='addform' onsubmit="addSubmit();">
  			<table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td width="150">Username:</td>
                  <td><input type='text' name='username' value='' class="input_1" style="width:200px;"></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td> Password:</td>
                  <td><input name="user_password1" type="password" id="user_password1" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Confirm Password: </td>
                  <td><input name="user_password2" type="password" id="user_password2" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
        <tr>
                  <td>First Name: </td>
                  <td><input name="fname" type="text" id="fname" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Middle Name: </td>
                  <td><input name="mname" type="text" id="mname" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Last Name: </td>
                  <td><input name="lname" type="text" id="lname" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top">Address:</td>
                  <td><textarea name="address" rows="5" id="address" style="width:350px;" class="input_1"></textarea></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Access Level :</td>
                  <td><select name="access_level" id="access_level" class="input_1" style="width:200px;">
				        <?
							foreach($accesslevel as $k=>$v){
								$x = std2arr($v['access']);
								echo '<option value="'.$x['id'].'">'.$x['name'].'</option>';
							}
						?>
                  </select></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Concerned Office (optional):</td>
                  <td><?php
							#if($ticket['status']=='dispatched'){
							#	echo $department;
							#}else{
								$t = count($departments);
								if($t){
									echo '<select id="department_id" name="department_id" class="input_1" style="width:200px;">';
									echo "<option value=\"\">--</option>";
									for($i=0; $i<$t; $i++){
										echo "<option value=\"".$departments[$i]->id."\">".$departments[$i]->department."</option>";
									}
									echo "</select>";
								}
							#}
							?></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Mobile:</td>
                  <td><input name="mobile" type="text" id="mobile" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Email Address: </td>
                  <td><input name="email" type="text" id="email" class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type='button' value='Submit' onclick='addSubmit();' class="btn_2" style="width:100px;"></td>
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
