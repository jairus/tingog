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
  <tr>
    <td class="text_1" colspan="9" align="right"><div style="padding:10px; font-weight:bold; font-size:12px;"><a href="/backend/report/exportCSV" target="_blank">Export to CSV</a></div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="70"><div style="padding:10px; font-weight:bold;">Report #</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="150"><div style="padding:10px; font-weight:bold;">Date</div></td>
    <td width="120" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Status</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Concerned Office</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="300"><div style="padding:10px; font-weight:bold;">Message</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Category</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="100"><div style="padding:10px; font-weight:bold;">Issue</div></td>
    <td width="100" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Barangay</div></td>
  </tr>
  <?php
  	$row_count = 0;
  	foreach($ticket_list as $k=>$r){
		#pre($r);
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
		//2012-03-13 11:17:55
  ?>
  <tr bgcolor="<?php echo $row_color; ?>">
    <td style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo zeroes($r['id'], 6); ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo date("M d, Y H:i",strtotime($r['date'])); ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo ucwords($r['status']); ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $r['department']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo word_limit(nl2br(urldecode($r['description'])), 20); ?><br></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo $r['category']; ?></div></td>
    <td style="border-bottom:1px solid #CCC;" class="text_1"><div style="padding:10px;"><?php echo $r['issue']; ?></div></td>
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