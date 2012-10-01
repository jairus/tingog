<link rel="stylesheet" type="text/css" href="/backend/styles/jquery.ui.datepicker.css" />
<script src="/backend/javascript/datepicker/jquery.ui.core.js"></script>
<script src="/backend/javascript/datepicker/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/backend/javascript/datepicker/jquery.ui.datepicker.js"></script>
<script>
$(function() {
	$( "#datepicker_from" ).datepicker();
});

$(function() {
	$( "#datepicker_to" ).datepicker();
});

function filterSubmit(){
	jQuery("#<? echo $report_container_id; ?>").html("Loading...");
	jQuery.ajax({
		type: 'POST',
		url: "<? echo $filter_ajax; ?>",
		data: jQuery("#filter").serialize(),
		success: function(message){
			jQuery("#<? echo $report_container_id; ?>").html(message);
		},
	});
}
</script>
<div id="message"></div>
<form name="filter" method="post" action="" id="filter">
  <p class="text_2">Concerned Office:
    <select name="department" id="department" class="input_1" style="width:150px;">
	  <option value="">--</option>
	  <?
	  	foreach($departments as $k => $v){
			echo "<option value=\"".$v['id']."\" ";
			if(isset($_POST['department']) && $_POST['department']==$v['id']) echo "selected";
			echo ">".$v['department']."</option>";
		}
	  ?>
    </select> 
  &nbsp;&nbsp; Category: 
  <select name="category" id="category" class="input_1" style="width:150px;">
	  <option value="">--</option>
	  <?
	  	foreach($categories as $k => $v){
			echo "<option value=\"".$v['id']."\" ";
			if(isset($_POST['category']) && $_POST['category']==$v['id']) echo "selected";
			echo ">".$v['category']."</option>";
		}
	  ?>
  </select>
  &nbsp;&nbsp; Issue: 
  <select name="issue" id="issue" class="input_1" style="width:150px;">
	  <option value="">--</option>
	  <?
	  	foreach($issues as $k => $v){
			echo "<option value=\"".$v['id']."\" ";
			if(isset($_POST['issue']) && $_POST['issue']==$v['id']) echo "selected";
			echo ">".$v['issue']."</option>";
		}
	  ?>
  </select>
  &nbsp;&nbsp; Barangay:
  <select name="location" id="location" class="input_1" style="width:150px;">
	  <option value="">--</option>
	  <?
	  	foreach($locations as $k => $v){
			echo "<option value=\"".$v['id']."\" ";
			if(isset($_POST['location']) && $_POST['location']==$v['id']) echo "selected";
			echo ">".$v['name']."</option>";
		}
	  ?>
  </select>
  </p>
  <p>&nbsp;</p>
  <?
  	if(isset($_POST['datepicker_from'])) $datepicker_from = $_POST['datepicker_from'];
	else $datepicker_from = "";
	
  	if(isset($_POST['datepicker_to'])) $datepicker_to = $_POST['datepicker_to'];
	else $datepicker_to = "";
  ?>
  <p class="text_2">Range: 
    <input name="datepicker_from" type="text" id="datepicker_from" class="input_1" style="width:150px;" value="<? echo $datepicker_from; ?>">
  - 
  <input name="datepicker_to" type="text" id="datepicker_to" class="input_1" style="width:150px;" value="<? echo $datepicker_to; ?>">
  </p>
  <p>&nbsp;</p>
  <p>
    <input name="Submit" type="button" class="btn_2" id="Submit" style="width:100px;" onClick="filterSubmit();" value="Submit">
  </p>
</form>
<div>&nbsp;</div>
<div id="<? echo $report_container_id; ?>">&nbsp;</div>