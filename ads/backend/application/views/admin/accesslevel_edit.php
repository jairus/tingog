<?
	
?>
<script>
function editSubmit(){
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/adminAccessLevelEditSubmit/<? echo $id; ?>",
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
        	<form id="editform">
              <label for="accessname">Access Level Name: </label>
        	  <input name="accessname" type="text" id="accessname" value="<? echo $accesslevel_name; ?>" />
              <ul>
                <?
				#pre($accesslevel_data);
	foreach(array_user_level() as $k => $v){
		#pre($v);
		echo "<li><div class=\"ui-widget-header\" style=\"padding:10px;\">".$k.'</div>';
		if(is_array($v['functions'])){
			echo '<ul>';
			#pre($v);
			foreach($v['functions'] as $kk => $vv){
				#pre($k);
				echo "<li><input name=\"".$v['class']."[".$kk."]\" type=\"checkbox\" id=\"".$v['class']."[".$kk."]\" value=\"".$kk."\" ";
				#if(is_array($accesslevel_data) && in_array($kk,$accesslevel_data)) echo 'checked="checked"';
				foreach($accesslevel_data as $kd => $kv){
					#pre($kv);
					if($kv['function']==$kk && $kv['class']==$v['class']) echo 'checked="checked"';
				}
				
				echo " /> ".$vv."</li>";
				// && ($v['class']==)
				#pre($vv);
			}
			echo '</ul>';
		}
		echo '</li>';
		echo '<br>';
  	}
  ?>
              </ul>
        	  <input name="button" type='button' onclick='editSubmit();' value='Update Access Level' />
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
