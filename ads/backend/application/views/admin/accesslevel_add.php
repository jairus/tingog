<script>
function addSubmit(){
	jQuery.ajax({
		type: 'POST',
		url: "/backend/admin/access",
		data: jQuery("#addform").serialize(),
		success: function(message){
			jQuery("#message").html(message);
		},
	});
}
</script>
<style>
li{
	list-style:none;
}
</style>
<table width="949" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="text_1"></td>
    </tr>
    <tr>
      <td class="text_2">
      	<div style="padding:5px;">
        	<div id='message'></div><br />
<form id="addform" name="addform" method="post" action="">
  <label for="accessname">Access Level Name: </label><input name="accessname" type="text" id="accessname" class="input_1" style="width:200px;" />
  <div>&nbsp;</div>
  <ul>
  <?
	foreach(array_user_level() as $k => $v){
		echo "<li><div class=\"ui-widget-header\" style=\"padding:10px;\">".$k.'</div>';
		if(is_array($v['functions'])){
			echo '<ul>';
			foreach($v['functions'] as $kk => $vv){
				echo "<li style='padding:10px 20px 5px;'><input name=\"functions[".$kk."]\" type=\"checkbox\" id=\"functions[".$kk."]\" value=\"".$kk."\" /> ".$vv."</li>";
			}
			echo '</ul>';
		}
		echo '</li>';
		echo '<br>';
  	}
  ?>
  </ul>
  <input type="submit" name="Submit" value="Submit" class="btn_2" style="width:100px;" />
</form>      	</div>
      </td>
    </tr>
    <tr>
      <td class="text_1"><div style="padding:5px;">&nbsp;</div></td>
    </tr>
    <tr>
      <td class="text_1"></td>
    </tr>
</table>
