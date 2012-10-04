<script>
function addDelete(id){
	if(confirm('Are you sure you want to delete this Access Level?')){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/admin/accessDeleteSubmit/"+id,
			success: function(message){
				jQuery("#message").html(message);
			},
		});
	}
}
</script>
<table width="949" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="text_1" colspan="8"><div style="padding:5px;"><hr /></div></td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="8">
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
    <td class="text_1" colspan="8"><div style="padding:5px;"><div id='message'></div><br /></div></td>
  </tr>
  <tr>
    <td class="text_1" colspan="8"><div style="padding:5px;"></div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Access Name</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="200"><div style="padding:10px; font-weight:bold;">Access Level </div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100">&nbsp;</td>
  </tr>
  <?
	$x = std2arr($accesslevel);
	$row_count = 0;
	foreach($x as $k => $v){
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
		if($v['users']){
			if($v['users']==1){
				$oc = "alert('There is ".$v['users']." User using this Access Level and you cannot delete this.');";
			}else{
				$oc = "alert('There are ".$v['users']." Users using this Access Level and you cannot delete this.');";
			}
		}else{
			#$oc = "window.location='/backend/admin/access/delete/".$v['access']['id']."'";
			$oc = "addDelete(".$v['access']['id'].")";
		}
  ?>
  
  <tr bgcolor="<? echo $row_color; ?>">
    <td valign="top" class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo($v['access']['name']); ?></div></td>
    <td valign="top" class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?
		foreach($v['options'] as $o=> $option){
			#echo $option['class'].'->'.$option['function'].'<br>';
			$name = return_access_name($option['function']);
			if($name) echo $name.'<br>';
		}
	?></div></td>
    <td align="center" valign="top" class="text_1" style="border-bottom:1px solid #CCC; padding-top:10px;">
      <input type="button" id="btn_spam_id" name="btn_spam" class="btn_1" value="edit" onclick="window.location='/backend/admin/adminAccessLevelEdit/<? echo($v['access']['id']); ?>'" />
&nbsp;
<input type="button" id="btn_tag_id" name="btn_tag" class="btn_1" value="delete" onclick="<? echo $oc; ?>" /></td>
  </tr>
  
  <?

  		$row_count++;

	}

  ?>
  <tr class="pagination">
    <td class="text_1" colspan="8"><div style="padding:5px;"></div></td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="8"><div style="padding:5px;">&nbsp;</div></td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="8">
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

