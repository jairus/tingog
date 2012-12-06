<?
	#pre($personnels);
	#pre($users);
?>
<div class="directory">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="parameter_1">
  <tr>
    <td class="text_1"><div style="padding:5px;">
        <hr />
      </div></td>
  </tr>
  <tr>
    <td class="text_3"><div style="padding:5px;">&nbsp;Personnels</div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td class="text_1">  <table width="100%">
  <tr bgcolor="#f2f1ed">
    <td width="370" bgcolor="#f2f1ed" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Name</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="251"><div style="padding:10px; font-weight:bold;">Concerned Office</div></td>
    <td style="border-bottom:1px solid #e3e2e0;" class="text_2"><div style="padding:10px; font-weight:bold;">Mobile Number </div></td>
    </tr>
  <?php
  	$row_count = 0;
  	foreach($personnels as $k=>$r){
		#pre($v);
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
  ?>
  <tr bgcolor="<?php echo $row_color; ?>">
    <td style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo $r['person']; ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php 
		  	$x = std2arr($this->admin->getDepartments($r['department']));
		  if(isset($x[0]['department'])) echo $x[0]['department']; ?></div></td>
    <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $r['mobile']; ?></div></td>
    </tr>
  <?php
  		$row_count++;
	}
  ?>
  </table></td>
  </tr>
  <tr>
    <td class="text_1"><div style="padding:5px;">&nbsp;</div></td>
  </tr>
  <tr>
    <td class="text_1"><div style="padding:5px;">
        <hr />
    </div></td>
  </tr>
  <tr>
    <td class="text_1">&nbsp;</td>
  </tr>
  <tr>
    <td class="text_3"><div style="padding:5px;">&nbsp;Users</div></td>
  </tr>
  <tr bgcolor="#f2f1ed">
    <td class="text_1"><table width="100%">
        <tr bgcolor="#f2f1ed">
          <td width="370" bgcolor="#f2f1ed" class="text_2" style="border-bottom:1px solid #e3e2e0;"><div style="padding:10px; font-weight:bold;">Name</div></td>
          <td style="border-bottom:1px solid #e3e2e0;" class="text_2" width="251"><div style="padding:10px; font-weight:bold;">Concerned Office</div></td>
          <td style="border-bottom:1px solid #e3e2e0;" class="text_2"><div style="padding:10px; font-weight:bold;">Mobile Number </div></td>
          <td style="border-bottom:1px solid #e3e2e0;" class="text_2"><div style="padding:10px; font-weight:bold;">Email </div></td>
        </tr>
        <?php
  	$row_count = 0;
  	foreach($users as $k=>$r){
		#pre($v);
		$row_color = (($row_count % 2)? "#ffffff" : "#f6f6f6");
  ?>
        <tr bgcolor="<?php echo $row_color; ?>">
          <td style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php echo $r['fname'].' '.$r['mname'].' '.$r['lname']; ?></div></td>
          <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><?php 
		  	$x = std2arr($this->admin->getDepartments($r['department']));
		  if(isset($x[0]['department'])) echo $x[0]['department']; ?></div></td>
          <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $r['mobile']; ?></div></td>
          <td class="text_1" style="border-bottom:1px solid #CCC;"><div style="padding:10px;"><? echo $r['email']; ?></div></td>
        </tr>
        <?php
  		$row_count++;
	}
  ?>
    </table></td>
  </tr>
</table>
</div>