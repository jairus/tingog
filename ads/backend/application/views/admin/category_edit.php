<script>
function editSubmit(){
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/categoryEditSubmit/<? echo $id; ?>",
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
                  <td width="150">Category Name:</td>
                  <td><input name='name' type='text' id="name" value='<? echo $name; ?>'></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="Button" type='button' value='Update' onclick="editSubmit();"></td>
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
