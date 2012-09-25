<script>
function addSubmit(){
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/personnelAddSubmit",
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
                  <td width="150">Personnel Name</td>
                  <td>: <input name='name' type='text' id="name" value='' class="input_1" style="width:200px;"></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Mobile No.</td>
                  <td>: <input name='mobile' type='text' id="mobile" value='' class="input_1" style="width:200px;" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td>Concerned Office</td>
                  <td>: <select name="department" id="department" class="input_1" style="width:200px;">
                    <?
						if(is_array($department)){
							foreach($department as $k=>$v){
								echo "<option value=\"".$v['id']."\" ";
								#if($v['id']==$did) echo "selected";
								echo ">".$v['department']."</option>";
							}
						}
					?>
                  </select></td>
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
