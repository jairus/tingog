<script>
function departmentDelete(id,form){
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/departmentsDeleteSubmit/"+id,
		data: jQuery(form).serialize(),
		success: function(message){
			jQuery("#message").html(message);
		},
	});
}
</script>
<table width="949" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="text_1" colspan="4"><div style="padding:5px;">
      <table width="949" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" width="150">Viewing records <b>1-50</b> of <b>150</b></td>
          <td align="left" width="100"><input type="button" id="btn_viewall_id" name="btn_viewall" class="btn_1" value="view all" /></td>
          <td align="left" width="200"><input type="button" id="btn_first_id" name="btn_first" class="btn_2" value="|&laquo;" />
                <input type="button" id="btn_prev_id" name="btn_prev" class="btn_2" value="&laquo;" />
            &nbsp; Page <b>1</b> of <b>3</b> &nbsp;
            <input type="button" id="btn_next_id" name="btn_next" class="btn_2" value="&raquo;" />
            <input type="button" id="btn_last_id" name="btn_last" class="btn_2" value="&raquo;|" /></td>
          <td align="right"><input type="text" id="input_search_id" name="input_search" value="" class="input_1" style="width:150px;" />
                <input type="button" id="btn_search_id" name="btn_search" class="btn_1" value="search" /></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td class="text_1" colspan="4"><div style="padding:5px;">&nbsp;</div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="30" align="center"><div style="padding:10px; font-weight:bold;">ID</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Username</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="300"><div style="padding:10px; font-weight:bold;">User Level </div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" align="center"><div style="padding:10px; font-weight:bold;">Actions</div></td>
  </tr>
  <?
  	$adminusers = std2arr($adminusers);
	$row_count = 0;
  	foreach($adminusers as $k=>$r){
		pre($r);
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
  ?>
  <form id="form<? echo $r['id']; ?>" name="form<? echo $r['id']; ?>" method="post" action="">
  <tr bgcolor="<? echo $row_color; ?>">
    <td class="text_2" width="30" align="center"><div style="padding:10px;"><? echo $r['id']; ?></div></td>
    <td class="text_2" width="100"><div style="padding:10px;"><? echo $r['user_login']; ?></div></td>
    <td class="text_2" width="400"><div style="padding:10px;"><? echo $r['user_level']; ?></div></td>
    <td class="text_2" align="center"><div style="padding:10px;">
      <input type="button" id="btn_spam_id" name="btn_spam" class="btn_1" value="edit" onclick="window.location='/backend/admin/adminEditAccount/<? echo $r['id']; ?>'" />
      &nbsp;
      <input type="button" id="btn_tag_id" name="btn_tag" class="btn_1" value="delete" />
    </div></td>
  </tr>
  </form>
  <?
  		$row_count++;
	}
  ?>
  <tr>
    <td class="text_1" colspan="4"><div style="padding:5px;">&nbsp;</div></td>
  </tr>
  <tr>
    <td class="text_1" colspan="4"><div style="padding:5px;">
      <table width="949" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" width="150">Viewing records <b>1-50</b> of <b>150</b></td>
          <td align="left" width="100"><input type="button" id="btn_viewall_id" name="btn_viewall2" class="btn_1" value="view all" /></td>
          <td align="left" width="200"><input type="button" id="btn_first_id" name="btn_first" class="btn_2" value="|&laquo;" />
                <input type="button" id="btn_prev_id" name="btn_prev" class="btn_2" value="&laquo;" />
            &nbsp; Page <b>1</b> of <b>3</b> &nbsp;
            <input type="button" id="btn_next_id" name="btn_next" class="btn_2" value="&raquo;" />
            <input type="button" id="btn_last_id" name="btn_last" class="btn_2" value="&raquo;|" /></td>
          <td align="right"><input type="text" id="input_search_id" name="input_search" value="" class="input_1" style="width:150px;" />
                <input type="button" id="btn_search_id" name="btn_search" class="btn_1" value="search" /></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>