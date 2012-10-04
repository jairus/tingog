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
  <tr bgcolor="#f2f1ed">
    <td class="text_1"><div style="padding:10px;"><div id='message'></div>
    </div></td>
  </tr>
  <tr>
    <td><iframe align="middle" height="400" width="100%" src="/includes/master.htm"></iframe></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td align="center" bgcolor="#f2f1ed" class="text_1"><div style="padding:10px;"></div></td>
  </tr>
</table>
</div>