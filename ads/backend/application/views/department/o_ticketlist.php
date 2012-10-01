<?
	#pre($_SESSION);
?>
<script>
function jqueryalert(x){
	alert(x);
}

function disableAllTabs(){
	jQuery("#btn_new_id")[0].className = "btn_1";
	jQuery("#btn_assigned_id")[0].className = "btn_1";
	jQuery("#btn_responded_id")[0].className = "btn_1";
	jQuery("#btn_parked_id")[0].className = "btn_1";

	jQuery("#parameter_1").hide();
	jQuery("#parameter_2").hide();
	jQuery("#parameter_3").hide();
	jQuery("#parameter_4").hide();
}

function tabToggle(n){
	if(n==1){
		disableAllTabs();
		
		jQuery("#btn_new_id")[0].className = "btn_1_active";

		jQuery("#parameter_1").show();
	}else if(n==2){
		disableAllTabs();
		
		jQuery("#btn_assigned_id")[0].className = "btn_1_active";

		jQuery("#parameter_2").show();
	}else if(n==3){
		disableAllTabs();
		
		jQuery("#btn_responded_id")[0].className = "btn_1_active";

		jQuery("#parameter_3").show();
	}else if(n==4){
		disableAllTabs();
		
		jQuery("#btn_parked_id")[0].className = "btn_1_active";

		jQuery("#parameter_4").show();
	}
}
</script>
<div class="ticket_list">
<table width="949" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="7">
    	<div style="padding:10px 0px;">
        	<input type="button" id="btn_new_id" name="btn_new" class="btn_1_active" value="New" style="width:100px;" onclick="tabToggle(1);" /> &nbsp; 
            <input type="button" id="btn_assigned_id" name="btn_assigned" class="btn_1" value="Assigned" style="width:100px;" onclick="tabToggle(2);" /> &nbsp; 
            <input type="button" id="btn_responded_id" name="btn_responded" class="btn_1" value="Resolved" style="width:100px;" onclick="tabToggle(3);" /> &nbsp; 
            <input type="button" id="btn_parked_id" name="btn_parked" class="btn_1" value="Parked" style="width:100px;" onclick="tabToggle(4);" />
        </div>
    </td>
  </tr>
</table>
<table width="949" border="0" cellspacing="0" cellpadding="0" id="parameter_1">
  <tr class="pagination">
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
        </div>    </td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="9"><div style="padding:5px;">&nbsp;</div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="70"><div style="padding:10px; font-weight:bold;">Report #</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="150"><div style="padding:10px; font-weight:bold;">Date</div></td>
    <td width="120" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Due</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Concerned Office</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="300"><div style="padding:10px; font-weight:bold;">Message</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Name</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Num/Email</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Barangay</div></td>
  </tr>
  <?php
  	$row_count = 0;
  	foreach($dispatched_tickets as $k=>$r){
		#pre($r);
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
		//2012-03-13 11:17:55
  ?>
  <tr bgcolor="<?php echo $row_color; ?>">
    <td style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo zeroes($r['id'], 6); ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo date("M d, Y H:i",strtotime($r['date'])); ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;">&nbsp;</div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $r['department']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo word_limit(nl2br(urldecode($r['description'])), 20); ?><br>
    <a href="#" onclick="openThreadDialog('<?php echo $r['id']; ?>');" class="link_3">Assign Report</a></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo $r['name']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php if($r['number']) echo $r['number']; else echo $r['email']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo $r['barangay']; ?></div></td>
  </tr>
  <?php
  		$row_count++;
	}
  ?>
  <tr>
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
        </div></td>
  </tr>
</table>

<table width="949" border="0" cellspacing="0" cellpadding="0" id="parameter_2" style="display:none;">
  <tr class="pagination">
    <td class="text_1" colspan="10"><div style="padding:5px;"><hr /></div></td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="10">
        <div style="padding:5px;">
        <table width="949" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" width="150">Viewing records <b>1-3</b> of <b>3</b></td>
            <td align="left" width="100"><input type="button" id="btn_viewall_id" name="btn_viewall" class="btn_1" value="view all" /></td>
            <td align="left" width="200"><input type="button" id="btn_first_id" name="btn_first" class="btn_2" value="|&laquo;" /> <input type="button" id="btn_prev_id" name="btn_prev" class="btn_2" value="&laquo;" /> &nbsp; Page <b>1</b> of <b>1</b> &nbsp; <input type="button" id="btn_next_id" name="btn_next" class="btn_2" value="&raquo;" /> <input type="button" id="btn_last_id" name="btn_last" class="btn_2" value="&raquo;|" /></td>
            <td align="right"><input type="text" id="input_search_id" name="input_search" value="" class="input_1" style="width:150px;" /> <input type="button" id="btn_search_id" name="btn_search" class="btn_1" value="search" /></td>
          </tr>
        </table>
        </div>
    </td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="10"><div style="padding:5px;">&nbsp;</div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="70"><div style="padding:10px; font-weight:bold;">Report #</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="170"><div style="padding:10px; font-weight:bold;">Date</div></td>
    <td width="120" class="text_2" style="border-bottom:1px solid #e3e2e0;" width="150"><div style="padding:10px; font-weight:bold;">Due</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Concerned Office</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Personnel</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="300"><div style="padding:10px; font-weight:bold;">Message</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Name</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Num/Email</div></td>
    <td class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Location</div></td>
  </tr>
  <?php
  	$row_count = 0;
  	foreach($assigned_tickets as $k=>$r){
		#pre($r);
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
		//2012-03-13 11:17:55
  ?>
  <tr bgcolor="<?php echo $row_color; ?>">
    <td style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo zeroes($r['id'], 6); ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo date("M d, Y H:i",strtotime($r['date'])); ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? 
		if(strtotime($r['duedate'])){
			echo date("M d, Y",strtotime($r['duedate'])); 
			if(time()>strtotime($r['duedate'])){
				$diff = round((time() - strtotime($r['duedate'])) / 60 / 60 / 24, 1);
				echo ' <span class="InfoContainer">'.$diff.' Day(s) Delayed</span>';
			}
		}
	?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $r['department']; ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $r['assign1']; if(strlen($r['assign2'])) echo '<br>'.$r['assign2'] ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo word_limit(nl2br(urldecode($r['description'])), 20); ?><br>
    <a href="#" onclick="openThreadDialog('<?php echo $r['id']; ?>');" class="link_3">Open Report</a></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo $r['name']; ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php if($r['number']) echo $r['number']; else echo $r['email']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo $r['barangay']; ?></div></td>
  </tr>
  <?php
  		$row_count++;
	}
  ?>
  <tr>
    <td class="text_1" colspan="10"><div style="padding:5px;">&nbsp;</div></td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="10">
        <div style="padding:5px;">
        <table width="949" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" width="150">Viewing records <b>1-3</b> of <b>3</b></td>
            <td align="left" width="100"><input type="button" id="btn_viewall_id" name="btn_viewall" class="btn_1" value="view all" /></td>
            <td align="left" width="200"><input type="button" id="btn_first_id" name="btn_first" class="btn_2" value="|&laquo;" /> <input type="button" id="btn_prev_id" name="btn_prev" class="btn_2" value="&laquo;" /> &nbsp; Page <b>1</b> of <b>1</b> &nbsp; <input type="button" id="btn_next_id" name="btn_next" class="btn_2" value="&raquo;" /> <input type="button" id="btn_last_id" name="btn_last" class="btn_2" value="&raquo;|" /></td>
            <td align="right"><input type="text" id="input_search_id" name="input_search" value="" class="input_1" style="width:150px;" /> <input type="button" id="btn_search_id" name="btn_search" class="btn_1" value="search" /></td>
          </tr>
        </table>
        </div>
    </td>
  </tr>
</table>

<table width="949" border="0" cellspacing="0" cellpadding="0" id="parameter_3" style="display:none;">
  <tr class="pagination">
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
        </div>
    </td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="8"><div style="padding:5px;">&nbsp;</div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="70"><div style="padding:10px; font-weight:bold;">Report #</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="150"><div style="padding:10px; font-weight:bold;">Date</div></td>
    <td width="120" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Due</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Concerned Office</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="300"><div style="padding:10px; font-weight:bold;">Message</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Name</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Num/Email</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Location</div></td>
  </tr>
  <?php
  	$row_count = 0;
  	foreach($responded_tickets as $k=>$r){
		#pre($r);
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
		//2012-03-13 11:17:55
  ?>
  <tr bgcolor="<?php echo $row_color; ?>">
    <td style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo zeroes($r['id'], 6); ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo date("M d, Y H:i",strtotime($r['date'])); ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;">&nbsp;</td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $r['department']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo word_limit(nl2br(urldecode($r['description'])), 20); ?><br>
    <a href="#" onclick="openThreadDialog('<?php echo $r['id']; ?>');" class="link_3">Open Report</a></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo $r['name']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php if($r['number']) echo $r['number']; else echo $r['email']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo $r['barangay']; ?></div></td>
  </tr>
  <?php
  		$row_count++;
	}
  ?>
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
        </div>
    </td>
  </tr>
</table>

<table width="949" border="0" cellspacing="0" cellpadding="0" id="parameter_4" style="display:none;">
  <tr class="pagination">
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
        </div>
    </td>
  </tr>
  <tr class="pagination">
    <td class="text_1" colspan="8"><div style="padding:5px;">&nbsp;</div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="70"><div style="padding:10px; font-weight:bold;">Report #</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="150"><div style="padding:10px; font-weight:bold;">Date</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="150"><div style="padding:10px; font-weight:bold;">Tagged</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Concerned Office</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="300"><div style="padding:10px; font-weight:bold;">Message</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Name</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Num/Email</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Location</div></td>
  </tr>
  <?php
  	$row_count = 0;
	$array_tag = array_parked();
  	foreach($parked_tickets as $k=>$r){
		#pre($r);
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
		//2012-03-13 11:17:55
  ?>
  <tr bgcolor="<?php echo $row_color; ?>">
    <td style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo zeroes($r['id'], 6); ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo date("M d, Y H:i",strtotime($r['date'])); ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php if($r['tag_park']) echo $array_tag[$r['tag_park']]; ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $r['department']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo word_limit(nl2br(urldecode($r['description'])), 20); ?><br>
    <a href="#" onclick="openThreadDialog('<?php echo $r['id']; ?>');" class="link_3">Edit Report</a> <? //echo "Read:".$r['read']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo $r['name']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php if($r['number']) echo $r['number']; else echo $r['email']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo $r['barangay']; ?></div></td>
  </tr>
  <?php
  		$row_count++;
	}
  ?>
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
        </div>
    </td>
  </tr>
</table>
</div>