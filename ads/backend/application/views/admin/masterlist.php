<?
	#pre($_SESSION);
?>
<script type="text/javascript" src="/backend/uploadify/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/backend/uploadify/swfobject.js"></script>
<script type="text/javascript" src="/backend/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
	$.ajaxSetup ({
		cache: false
	}); 
	
	$('#Filedata').uploadify({
		'uploader'  : '/backend/uploadify/uploadify.swf',
		'script'    : '/backend/uploadify/uploadify.php',
		'cancelImg' : '/backend/uploadify/cancel.png',
		'folder'    : '/backend/uploads',
		'auto'      : true
	});
	
	//$("#masterlist_img").fadeOut("slow");
});
// ]]>
function submitForm(){
	jQuery.ajax({
		type: 'POST',
		url: "/backend/cityaccess/masterListSubmit",
		data: jQuery("#masterform").serialize(),
		success: function(message){
			jQuery("#masterlist_text").html(message);
		},
	});
	//$("#masterImg").attr("src", "/backend/uploads/masterListImg.jpg?t=" + new Date().getTime());
}
</script>
<div>
  <table width="949" border="0" cellspacing="0" cellpadding="0" id="parameter_1">
  <tr>
    <td width="820" class="text_2"><div style="padding:5px;">
        <hr />
      </div></td>
  </tr>
  <tr>
    <td class="text_3"><div style="padding:5px;">&nbsp;Master List </div></td>
  </tr>
  <?
  	if($_SESSION['access_level']=='admin'){
  ?>
  <tr bgcolor="#f2f1ed">
    <td class="text_1"><div style="padding:10px;"><div id='message'></div><br />
	<form action="" method="post" enctype="multipart/form-data" name="masterform" id="masterform">
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td width="150"><b>Image Upload:</b></td>
          <td><input id="Filedata" type="file" name="Filedata" class="input_1" /></td>
        </tr>
        <tr>
          <td valign="top"><br />
            <b>Text:</b></td>
          <td><br />
            <textarea name="text" rows="10" id="text" style="width:350px;" class="input_1"></textarea></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="Submit" type="button" id="Submit" onclick="submitForm();" value="Submit" class="btn_2" style="width:100px;" /></td>
        </tr>
      </table>
        </form></div></td>
  </tr>
  <?
  	}
  ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td align="center" bgcolor="#f2f1ed" class="text_1"><?
		$af = array();
		$handle = opendir("uploads");
		$allow = array('xls','xlsx','doc','docx');
		while ($file = readdir($handle)){
			$files[] = $file;
		}
		unset($files[0]);
		unset($files[1]);
		closedir($handle);
		
		foreach ($files as $x) {
			$fileexplode = explode(".",$x);
			$ext = $fileexplode[(count($fileexplode))-1];
			#if(in_array($ext,$allow)){
				$af[] = $x;	
			#}
		}
		natcasesort($af);
		foreach($af as $file){
			echo "<div>".$file."</div>";
		}
		?></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td align="center" bgcolor="#f2f1ed" class="text_1">&nbsp;</td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td align="center" bgcolor="#f2f1ed" class="text_1"><div style="padding:10px;"><div id="masterlist_text"><? echo nl2br($text); ?></div></div></td>
  </tr>
</table>
</div>