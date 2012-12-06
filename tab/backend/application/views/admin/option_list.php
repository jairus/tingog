<script>
function optionDelete(id,form){
	if(confirm('Please confirm delete')){
		jQuery.ajax({
			type: 'POST',
			url: "/backend/admin/<? echo $delete_method; ?>/"+id,
			data: jQuery(form).serialize(),
			success: function(message){
				jQuery("#message").html(message);
			},
		});
	}
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="text_1" colspan="4"><div style="padding:5px;"><div id='message'></div><br /></div></div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <?
		foreach($table_titles as $title){
	?>
	<td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="30"><div style="padding:10px; font-weight:bold;"><? echo $title; ?></div></td>
	<?
		}
	
	?>
	<td style="border-bottom:1px solid #e3e2e0;" class="text_2" align="center"><div style="padding:10px; font-weight:bold;">Actions</div></td>
  </tr>
  <?
	$row_count = 0;
  	foreach($list as $k=>$r){
		#pre($r);
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
		if(isset($r['delete_unable_msg'])){
			$oc = "alert('".$r['delete_unable_msg']."')";
		}else{
			$oc = "optionDelete(".$r['id'].")";
		}
  ?>
  
  <tr bgcolor="<? echo $row_color; ?>">
    <?
		foreach($table_titles as $key){
	?>
	<td class="text_2" width="30"><div style="padding:10px;"><? echo $r[strtolower($key)]; ?></div></td>
	<?
		}
	
	?>
	<td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="30" align="center"><div style="padding:10px; font-weight:bold;"><input type="button" id="btn_spam_id" name="btn_spam" class="btn_1" value="edit" onclick="window.location='<? echo $r['edit_link']; ?>'" />
      &nbsp;
      <input type="button" id="btn_tag_id" name="btn_tag" class="btn_1" value="delete" onclick="<? echo $oc; ?>" /></div></td>
  </tr>
  
  <?
  		$row_count++;
	}
  ?>
</table>
