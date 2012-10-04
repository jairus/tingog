<script>
function brgyDelete(id){
	if(confirm('Are you sure you want to delete this Barangay?')){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/admin/barangayDeleteSubmit/"+id,
			success: function(message){
				jQuery("#message").html(message);
			},
		});
	}
}
</script>
<table width="949" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="text_1" colspan="9"><div style="padding:5px;"><hr /></div></td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="9">
        <div style="padding:5px;">
        <table width="949" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" width="150">Viewing records <b>1-3</b> of <b>3</b></td>
            <td align="left" width="100"><input type="button" id="btn_viewall_id" name="btn_viewall" class="btn_1" value="view all" /></td>
            <td align="left" width="200"><input type="button" id="btn_first_id" name="btn_first" class="btn_2" value="|&laquo;" /> <input type="button" id="btn_prev_id" name="btn_prev" class="btn_2" value="&laquo;" /> &nbsp; Page <b>1</b> of <b>1</b> &nbsp; <input type="button" id="btn_next_id" name="btn_next" class="btn_2" value="&raquo;" /> <input type="button" id="btn_last_id" name="btn_last" class="btn_2" value="&raquo;|" /></td>
            <td align="right"><input type="text" id="input_search_id" name="input_search" value="" class="input_1" style="width:150px;" /> <input type="button" id="btn_search_id" name="btn_search" class="btn_1" value="search" /></td>
          </tr>
        </table>
        </div></td>
  </tr>
  <tr>
    <td class="text_1" colspan="9"><div style="padding:5px;"><div id='message'></div><br /></div></td>
  </tr>
  <tr>
    <td class="text_1" colspan="9"><div style="padding:5px;"></div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Name</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Longitude</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><span style="padding:10px; font-weight:bold;">Lattitude</span></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100">&nbsp;</td>
  </tr>
  <?
	$x = std2arr($list);
	$row_count = 0;
	foreach($x as $k => $v){
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
  ?>
  
  <tr bgcolor="<? echo $row_color; ?>">
    <td valign="top" class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $v['name']; ?></div></td>
    <td valign="top" class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $v['long']; ?></div></td>
    <td valign="top" class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $v['lat']; ?></div></td>
    <td align="center" valign="top" class="text_1" style="border-bottom:1px solid #CCC; padding-top:10px;">
      <input type="button" id="btn_spam_id" name="btn_spam" class="btn_1" value="edit" onclick="window.location='/backend/admin/barangayEdit/<? echo($v['id']); ?>'" />
&nbsp;
<input type="button" id="btn_tag_id" name="btn_tag" class="btn_1" value="delete" onclick="brgyDelete(<? echo $v['id']; ?>);" /></td>
  </tr>
  
  <?

  		$row_count++;

	}

  ?>
  <tr class="pagination">
    <td class="text_1" colspan="9"><div style="padding:5px;"></div></td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="9"><div style="padding:5px;">&nbsp;</div></td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="9">
        <div style="padding:5px;">
        <table width="949" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" width="150">Viewing records <b>1-3</b> of <b>3</b></td>
            <td align="left" width="100"><input type="button" id="btn_viewall_id" name="btn_viewall" class="btn_1" value="view all" /></td>
            <td align="left" width="200"><input type="button" id="btn_first_id" name="btn_first" class="btn_2" value="|&laquo;" /> <input type="button" id="btn_prev_id" name="btn_prev" class="btn_2" value="&laquo;" /> &nbsp; Page <b>1</b> of <b>1</b> &nbsp; <input type="button" id="btn_next_id" name="btn_next" class="btn_2" value="&raquo;" /> <input type="button" id="btn_last_id" name="btn_last" class="btn_2" value="&raquo;|" /></td>
            <td align="right"><input type="text" id="input_search_id" name="input_search" value="" class="input_1" style="width:150px;" /> <input type="button" id="btn_search_id" name="btn_search" class="btn_1" value="search" /></td>
          </tr>
        </table>
        </div>    </td>
  </tr>
</table>

